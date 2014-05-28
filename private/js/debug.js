(function() {

    /**
    * Selects the contents of a node
    */
    function selectNode(node) {
        if (document.body.createTextRange) {
            var range = document.body.createTextRange();
            range.moveToElementText(node);
            range.select();
        } else if (window.getSelection) {
            var selection = window.getSelection();
            var range = document.createRange();
            range.selectNodeContents(node);
            selection.removeAllRanges();
            selection.addRange(range);
        } else {
            var selection = window.getSelection();
            selection.setBaseAndExtent(node, 0, node, 1);
        }
    }

    // Swap file paths and select
    var paths = document.getElementsByClassName('mammoth-debug-path');
    for (var i = 0, l = paths.length; i < l; i++) {
        paths[i].onclick = function() {
            var title = this.title;
            this.title = this.innerHTML;
            this.innerHTML = title;
            selectNode(this);
        }
    }

    // Auto scroll checkbox
    var checked = true;
    var checkboxes = document.getElementsByClassName('mammoth-debug-autoscroll');
    for (var i = 0, l = checkboxes.length; i < l; i++) {
        this.checked = true;
        checkboxes[i].onclick = function() {
            checked = this.checked;
        }
    }

    // Auto scoll mouse move
    var wrappers = document.getElementsByClassName('mammoth-debug-wrapper');
    for (i = 0, l = wrappers.length; i < l; i++) {
        wrappers[i].onmousemove = function(event) {
            if (!checked) {
                return;
            }
            var left = 0, obj = this;
            do {
                left += obj.offsetLeft;
            } while (obj = obj.offsetParent);

            var width = this.offsetWidth - 60;
            var position = Math.max(event.clientX - left - 30, 0);
            var percent = Math.min(1 / width * position, 1);
            var max = this.scrollWidth - 60 - width;
            this.scrollLeft = max * percent;
        };
    }
})();
