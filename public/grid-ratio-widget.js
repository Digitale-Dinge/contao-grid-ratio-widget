/**
 * Grid ratio widget — column proportions on a 12-unit base.
 *
 * Stores a ready-to-use fr list (e.g. "4fr 8fr") in a hidden input. A number
 * stepper sets the column count (2–4); a drag ruler sets the proportions and
 * snaps to twelfths (so 2/3/4 columns can be split evenly and in exact
 * thirds/quarters). The ruler shows rounded percentages; the stored value is fr.
 *
 */
{
    const TOTAL = 12; // 12-unit base
    const MIN = 2;
    const MAX = 4;

    /** Parse "4fr 8fr" -> [4, 8] (or null if it is not a valid fr list). */
    const parseUnits = (value) => {
        const parts = String(value || '')
            .trim()
            .split(/\s+/)
            .map((part) => parseInt(part, 10))
            .filter((n) => Number.isInteger(n) && n >= 1);

        return parts.length >= MIN && parts.length <= MAX ? parts : null;
    };

    /** Even split on the 12-base, e.g. 2 -> [6,6], 3 -> [4,4,4], 4 -> [3,3,3,3]. */
    const evenUnits = (n) => {
        const base = Math.floor(TOTAL / n);
        const units = Array.from({ length: n }, () => base);
        for (let rest = TOTAL - base * n, i = 0; rest > 0; i++, rest--) {
            units[i] += 1;
        }
        return units;
    };

    const initWidget = (container) => {
        if (container.dataset.ready) {
            return;
        }
        container.dataset.ready = '1';

        const input = container.querySelector('input[type="hidden"]');
        const bar = container.querySelector('.grid-ratio__bar');
        const counter = container.querySelector('.grid-ratio__count');
        if (!input || !bar) {
            return;
        }

        let units = parseUnits(input.value) ?? evenUnits(MIN);
        let segments = [];
        let labels = [];
        let handles = [];

        const writeValue = () => {
            input.value = units.map((u) => `${u}fr`).join(' ');
        };

        /** Cumulative unit boundaries between segments (length = units.length - 1). */
        const boundaries = () => {
            const result = [];
            let acc = 0;
            for (let i = 0; i < units.length - 1; i++) {
                acc += units[i];
                result.push(acc);
            }
            return result;
        };

        const paint = () => {
            const bounds = boundaries();
            units.forEach((u, i) => {
                segments[i].style.flexGrow = String(u);
                labels[i].textContent = `${Math.round((u / TOTAL) * 100)}%`;
            });
            handles.forEach((handle, i) => {
                handle.style.left = `${(bounds[i] / TOTAL) * 100}%`;
            });
        };

        const startDrag = (event, index) => {
            event.preventDefault();
            const handle = handles[index];
            try {
                handle.setPointerCapture(event.pointerId);
            } catch {
                /* not supported – dragging still works */
            }

            const onMove = (moveEvent) => {
                const rect = bar.getBoundingClientRect();
                if (!rect.width) {
                    return;
                }
                const bounds = boundaries();
                const lower = index === 0 ? 1 : bounds[index - 1] + 1;
                const upper = index === bounds.length - 1 ? TOTAL - 1 : bounds[index + 1] - 1;

                let pos = Math.round(((moveEvent.clientX - rect.left) / rect.width) * TOTAL);
                pos = Math.min(Math.max(pos, lower), upper);
                bounds[index] = pos;

                const next = [];
                let prev = 0;
                bounds.forEach((bound) => {
                    next.push(bound - prev);
                    prev = bound;
                });
                next.push(TOTAL - prev);
                units = next;

                writeValue();
                paint();
            };

            const onEnd = () => {
                handle.removeEventListener('pointermove', onMove);
                handle.removeEventListener('pointerup', onEnd);
                handle.removeEventListener('pointercancel', onEnd);
            };

            handle.addEventListener('pointermove', onMove);
            handle.addEventListener('pointerup', onEnd);
            handle.addEventListener('pointercancel', onEnd);
        };

        const build = () => {
            segments = [];
            labels = [];
            handles = [];
            bar.replaceChildren();

            if (counter) {
                counter.value = String(units.length);
            }

            units.forEach(() => {
                const segment = document.createElement('div');
                segment.className = 'grid-ratio__seg';
                const label = document.createElement('span');
                label.className = 'grid-ratio__label';
                segment.append(label);
                bar.append(segment);
                segments.push(segment);
                labels.push(label);
            });

            for (let i = 0; i < units.length - 1; i++) {
                const handle = document.createElement('div');
                handle.className = 'grid-ratio__handle';
                const index = i;
                handle.addEventListener('pointerdown', (event) => startDrag(event, index));
                bar.append(handle);
                handles.push(handle);
            }

            paint();
        };

        const setCount = (n) => {
            const clamped = Math.min(MAX, Math.max(MIN, n));
            units = evenUnits(clamped);
            writeValue();
            build();
        };

        // Delegate the change so it works regardless of choices.js init order
        // (the change event bubbles up to the container).
        container.addEventListener('change', (event) => {
            if (event.target?.classList.contains('grid-ratio__count')) {
                const n = parseInt(event.target.value, 10);
                if (Number.isInteger(n)) {
                    setCount(n);
                }
            }
        });

        build();

        // Persist the default immediately so an untouched widget still saves a value.
        if (!parseUnits(input.value)) {
            writeValue();
        }
    };

    const scan = (node) => {
        if (node.nodeType !== 1) {
            return;
        }
        if (node.matches?.('.grid-ratio')) {
            initWidget(node);
        }
        node.querySelectorAll?.('.grid-ratio').forEach(initWidget);
    };

    // Observe <html> (not <body>): Contao's backend uses Turbo, which swaps the
    // <body> on navigation/save. documentElement persists, so the widget keeps
    // initialising after a save and when sub-palettes appear.
    document.querySelectorAll('.grid-ratio').forEach(initWidget);
    new MutationObserver((mutations) => {
        mutations.forEach((mutation) => mutation.addedNodes.forEach(scan));
    }).observe(document.documentElement, { childList: true, subtree: true });
}
