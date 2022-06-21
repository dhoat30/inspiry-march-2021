(function($) {
    FWP.hooks.addAction('facetwp/refresh/color', function($this, facet_name) {
        var selected_values = [];
        $this.find('.facetwp-color.checked').each(function() {
            selected_values.push($(this).attr('data-value'));
        });
        FWP.facets[facet_name] = selected_values;
    });

    FWP.hooks.addFilter('facetwp/selections/color', function(output, params) {
        var choices = [];
        $.each(params.selected_values, function(val) {
            choices.push({
                value: val,
                label: val
            });
        });
        return choices;
    });

    $().on('click', '.facetwp-facet .facetwp-color:not(.disabled)', function(e) {
        if (true === e.handled) {
            return false;
        }
        e.handled = true;
        $(this).toggleClass('checked');
        FWP.autoload();
    });

    $().on('facetwp-loaded', function() {
        $('.facetwp-color').each(function() {
            var $this = $(this);
            var el = $this.nodes[0];
            el.style.backgroundColor = $this.attr('data-color');
            if (null !== $this.attr('data-img')) {
                el.style.backgroundImage = 'url("' + $this.attr('data-img') + '")';
                el.style.backgroundPosition = 'center';
                el.style.backgroundSize = 'cover';
            }
        });
    });
})(fUtil);
