(function(window, document, undefined) {
    'use strict';

    var tooltip = {

        init: function() {
            this.listen();
        },

        listen: function() {
            [].forEach.call(document.querySelectorAll('.scope-warning'), function(el) {
                el.addEventListener('mouseover', function() {
                    this.getElementsByTagName('div')[0].classList.add('active');
                });
                el.addEventListener('mouseout', function() {
                    this.getElementsByTagName('div')[0].classList.remove('active');
                });
            });
        }

    };

    document.addEventListener('DOMContentLoaded', function() {
        tooltip.init();
    });

})(window, document);
