var a2lix_libJS = a2lix_libJS || {};

a2lix_libJS.formCollection = (function() {
    "use strict";

    var pub = {};

    pub.construct = function($div)
    {
        var prototype = $div.data('prototype');

        var $addLink = $('<a href="#">Add entry</a>').appendTo($div);
        $addLink.on('click', function() {
            var nbEntries = $div.children('div').length,
                htmlEntry = prototype.replace(/__name__label__/g, nbEntries)
                                     .replace(/__name__/g, nbEntries);

            $(htmlEntry).insertBefore(this);
        });
    };

    return pub;
})();

var $formCollection = $('form').find('div[data-a2lix-formcollection]');
if ($formCollection.length) {
    $formCollection.each(function() {
        a2lix_libJS.formCollection.construct($(this));
    })
}