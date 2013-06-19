(function(document) {
    'use strict';

    function tooltips() {
        [].forEach.call(document.querySelectorAll('.scope-warning'), function(el) {
            el.addEventListener('mouseover', function() {
                this.getElementsByTagName('div')[0].classList.add('active');
            });
            el.addEventListener('mouseout', function() {
                this.getElementsByTagName('div')[0].classList.remove('active');
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        tooltips();
    });

})(document);
