/**
 * Theme front-end helpers.
 */
(function () {
    const fixedHeaderSelectors = {
        container: '.wp-site-blocks',
        header: '.wp-site-blocks > header',
        main: '.wp-site-blocks > main',
    };

    const faqSelectors = {
        block: '.wp-block-yoast-faq-block',
        section: '.schema-faq-section',
        question: '.schema-faq-question',
        answer: '.schema-faq-answer',
    };

    const adjustMainPaddingForHeader = () => {
        const header = document.querySelector(fixedHeaderSelectors.header);
        const main = document.querySelector(fixedHeaderSelectors.main);

        if (!header || !main) {
            return;
        }

        const headerHeight = header.getBoundingClientRect().height;
        main.style.paddingTop = `${headerHeight}px`;
    };

    const initFixedHeaderSpacing = () => {
        const container = document.querySelector(fixedHeaderSelectors.container);

        if (!container) {
            return;
        }

        adjustMainPaddingForHeader();
        window.addEventListener('resize', adjustMainPaddingForHeader);
        window.addEventListener('orientationchange', adjustMainPaddingForHeader);
    };

    const generateId = (prefix) => `${prefix}-${Math.random().toString(36).slice(2, 11)}`;

    const toggleFaqSection = (section, question, answer) => {
        const willOpen = !section.classList.contains('is-open');
        const cleanUpListener = (listener) => {
            answer.removeEventListener('transitionend', listener);
        };

        if (willOpen) {
            section.classList.add('is-open');
            question.setAttribute('aria-expanded', 'true');
            answer.hidden = false;

            const targetHeight = answer.scrollHeight;

            answer.style.maxHeight = '0px';
            answer.style.opacity = '0';

            requestAnimationFrame(() => {
                answer.style.maxHeight = `${targetHeight}px`;
                answer.style.opacity = '1';
            });

            const onOpenTransitionEnd = (event) => {
                if (event.propertyName !== 'max-height') {
                    return;
                }

                answer.style.maxHeight = 'none';
                answer.style.removeProperty('opacity');
                cleanUpListener(onOpenTransitionEnd);
            };

            answer.addEventListener('transitionend', onOpenTransitionEnd);
        } else {
            section.classList.remove('is-open');
            question.setAttribute('aria-expanded', 'false');

            const startHeight = answer.scrollHeight;
            answer.style.maxHeight = `${startHeight}px`;
            answer.style.opacity = '1';

            requestAnimationFrame(() => {
                answer.style.maxHeight = '0px';
                answer.style.opacity = '0';
            });

            const onCloseTransitionEnd = (event) => {
                if (event.propertyName !== 'max-height') {
                    return;
                }

                answer.hidden = true;
                answer.style.removeProperty('max-height');
                answer.style.removeProperty('opacity');
                cleanUpListener(onCloseTransitionEnd);
            };

            answer.addEventListener('transitionend', onCloseTransitionEnd);
        }
    };

    const initFaqAccordions = () => {
        const faqBlocks = document.querySelectorAll(faqSelectors.block);

        if (!faqBlocks.length) {
            return;
        }

        faqBlocks.forEach((block) => {
            const sections = block.querySelectorAll(faqSelectors.section);

            sections.forEach((section) => {
                const question = section.querySelector(faqSelectors.question);
                const answer = section.querySelector(faqSelectors.answer);

                if (!question || !answer) {
                    return;
                }

                const startOpen = section.classList.contains('is-open');
                section.classList.toggle('is-open', startOpen);
                answer.hidden = !startOpen;

                if (startOpen) {
                    answer.style.maxHeight = 'none';
                    answer.style.opacity = '1';
                } else {
                    answer.style.maxHeight = '0px';
                    answer.style.opacity = '0';
                }

                if (!answer.id) {
                    answer.id = generateId('faq-answer');
                }

                question.setAttribute('role', 'button');
                question.setAttribute('tabindex', '0');
                question.setAttribute('aria-expanded', String(startOpen));
                question.setAttribute('aria-controls', answer.id);

                const handler = () => toggleFaqSection(section, question, answer);

                if (!question.dataset.accordionBound) {
                    question.addEventListener('click', handler);
                    question.addEventListener('keydown', (event) => {
                        if (event.key === 'Enter' || event.key === ' ') {
                            event.preventDefault();
                            handler();
                        }
                    });

                    question.dataset.accordionBound = 'true';
                }
            });
        });
    };

    const init = () => {
        initFixedHeaderSpacing();
        initFaqAccordions();
    };

    if (document.readyState !== 'loading') {
        init();
    } else {
        document.addEventListener('DOMContentLoaded', init);
    }
})();
