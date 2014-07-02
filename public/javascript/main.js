//= require ./token.js

$(document.body).removeClass('preload');

$('[data-note]').each(function() {
  var note = $(this);
  var before = $(this).data('before');
  var after = $(this).data('after');
  var diff = JsDiff.diffChars(before, after);
  diff.forEach(function(part) {
    var span = $('<span />', {'class': part.added?'note-added':part.removed?'note-removed':''});
    span.text(part.value);
    note.append(span);
  });
});

$(document).on('lozenge:fetch', '[data-tags]', function(event, lozenge) {
  lozenge.preventDefault();
  lozenge.createOption(lozenge.value);
  $.get(TAGS_URI, function(tags) {
    $(tags).each(function() {
      if (this.name == lozenge.value) {
        lozenge.createOption(false);
      }
      lozenge.addOption({"id":this.id, "html":this.name});
    });
  });
});

$(document).on('lozenge:store', '[data-tags]', function(event, lozenge) {
  lozenge.preventDefault();
  $.post(TAGS_URI, {'tag':{'name':lozenge.value}}, function(tag) {
    lozenge.callback({"id":tag.id, "html":tag.name});
  });
});

$(document).on('lozenge:fetch', '[data-search]', function(event, lozenge) {
  lozenge.preventDefault();
  lozenge.createOption(lozenge.value);
  lozenge.addOptions([
    {'id': 'status:pending', 'html':'Status: Pending'},
    {'id': 'status:accepted', 'html':'Status: Accepted'},
    {'id': 'status:rejected', 'html':'Status: Rejected'},
    {'id': 'status:delivered', 'html':'Status: Delivered'},
    {'id': 'status:closed', 'html':'Status: Closed'}
  ]);
});
