import './jquery';
import './select2';
import './sweetAlert2';

import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';
window.Swiper = Swiper;

// auto slug create
document.getElementById('title').addEventListener('input', function () {
    let slug = this.value
        .toLowerCase()
        .trim()
        .replace(/\s+/g, '-');
    document.getElementById('slug').value = slug;

    document.getElementById('slug').dispatchEvent(new Event('input'));
});