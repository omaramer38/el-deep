import Lenis from 'lenis';
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

export function initMotion() {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const isTouch = 'ontouchstart' in window || navigator.maxTouchPoints > 0;

    // Initialize Lenis only if reduced motion is false and not problematic touch
    let lenis = null;
    if (!prefersReducedMotion && !isTouch) {
        lenis = new Lenis({
            lerp: 0.09,
            smoothWheel: true,
            wheelMultiplier: 1,
        });

        lenis.on('scroll', ScrollTrigger.update);

        gsap.ticker.add((time) => {
            lenis.raf(time * 1000);
        });

        gsap.ticker.lagSmoothing(0);
    }

    // Direction helper for RTL support
    const dir = parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--dir')) || 1;

    // Reveal animations on scroll
    if (!prefersReducedMotion) {
        // Elements with data-reveal attribute
        const revealElements = document.querySelectorAll('[data-reveal]');
        revealElements.forEach((el) => {
            const effect = el.dataset.reveal || 'fade-up';
            const delay = parseFloat(el.dataset.delay || 0);

            if (effect === 'fade-up') {
                gsap.fromTo(el, 
                    { opacity: 0, y: 36 }, 
                    {
                        opacity: 1,
                        y: 0,
                        duration: 0.85,
                        delay: delay,
                        ease: 'power3.out',
                        scrollTrigger: {
                            trigger: el,
                            start: 'top 88%',
                            toggleActions: 'play none none none',
                        }
                    }
                );
            } else if (effect === 'fade-slide') {
                // RTL-aware horizontal slide
                gsap.fromTo(el,
                    { opacity: 0, x: 40 * dir },
                    {
                        opacity: 1,
                        x: 0,
                        duration: 0.85,
                        delay: delay,
                        ease: 'power3.out',
                        scrollTrigger: {
                            trigger: el,
                            start: 'top 88%',
                            toggleActions: 'play none none none',
                        }
                    }
                );
            } else if (effect === 'fade') {
                gsap.fromTo(el,
                    { opacity: 0 },
                    {
                        opacity: 1,
                        duration: 0.7,
                        delay: delay,
                        ease: 'power2.out',
                        scrollTrigger: {
                            trigger: el,
                            start: 'top 90%',
                            toggleActions: 'play none none none',
                        }
                    }
                );
            }
        });

        // Number counter animation: [data-counter]
        const counterElements = document.querySelectorAll('[data-counter]');
        counterElements.forEach((el) => {
            const target = parseFloat(el.dataset.counter) || 0;
            const prefix = el.dataset.prefix || '';
            const suffix = el.dataset.suffix || '';
            const decimals = parseInt(el.dataset.decimals || 0, 10);

            ScrollTrigger.create({
                trigger: el,
                start: 'top 90%',
                once: true,
                onEnter: () => {
                    const obj = { val: 0 };
                    gsap.to(obj, {
                        val: target,
                        duration: 1.8,
                        ease: 'power2.out',
                        onUpdate: () => {
                            el.textContent = prefix + obj.val.toFixed(decimals) + suffix;
                        }
                    });
                }
            });
        });

        // Header dynamic state on scroll
        const header = document.querySelector('[data-header]');
        if (header) {
            let lastScrollY = window.scrollY;
            window.addEventListener('scroll', () => {
                const currentScrollY = window.scrollY;
                if (currentScrollY > 80) {
                    header.classList.add('is-scrolled');
                } else {
                    header.classList.remove('is-scrolled');
                }

                if (currentScrollY > 300 && currentScrollY > lastScrollY) {
                    header.classList.add('is-hidden');
                } else {
                    header.classList.remove('is-hidden');
                }
                lastScrollY = currentScrollY;
            }, { passive: true });
        }
    }

    return { lenis, gsap, ScrollTrigger };
}
