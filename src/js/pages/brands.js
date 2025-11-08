import Swiper from 'swiper';
import { Navigation, Pagination } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

const initBrandsCarousel = () => {
  const section = document.querySelector('[data-brands-slider]');
  if (!section) return null;

  const container = section.querySelector('.swiper');
  const paginationEl = section.querySelector('.brands-carousel__pagination');
  const nextEl = section.querySelector('.brands-carousel__nav--next');
  const prevEl = section.querySelector('.brands-carousel__nav--prev');
  const navStack = section.querySelector('.brands-carousel__nav-stack');

  if (!container) return null;

  const slides = container.querySelectorAll('.swiper-slide');
  const hasMultipleSlides = slides.length > 1;

  if (!hasMultipleSlides) {
    if (paginationEl) paginationEl.style.display = 'none';
    if (nextEl) nextEl.style.display = 'none';
    if (prevEl) prevEl.style.display = 'none';
    if (navStack) navStack.style.display = 'none';
  }

  const totalSlides = slides.length;
  const middleIndex = Math.floor(totalSlides / 2);

  const swiper = new Swiper(container, {
    modules: [Navigation, Pagination],

    // desktop/tablet defaults
    direction: 'vertical',
    centeredSlides: true,
    slidesPerView: 1.6,
    spaceBetween: 21,
    loop: true,
    initialSlide: middleIndex,
    mousewheel: true,

    pagination: paginationEl
      ? {
          el: paginationEl,
          clickable: true,
        }
      : false,

    navigation:
      hasMultipleSlides && nextEl && prevEl
        ? {
            nextEl,
            prevEl,
          }
        : false,

    breakpoints: {
      0: {
        direction: 'horizontal',
        slidesPerView: 1.1,
        centeredSlides: true,
        spaceBetween: 21,
        mousewheel: false,
        pagination: {
          el: paginationEl,
          clickable: true,
          enabled: true,
        },
        navigation: false,
      },
      769: {
        direction: 'vertical',
        slidesPerView: 1.6,
        centeredSlides: true,
        spaceBetween: 21,
        pagination: {
          el: paginationEl,
          enabled: false, // hide dots on desktop
        },
        navigation: {
          nextEl,
          prevEl,
        },
        mousewheel: true,
      },
    },
  });

  return swiper;
};

export default initBrandsCarousel;