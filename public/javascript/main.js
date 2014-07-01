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
  $.get(TAGS_URI, function(tags) {
    lozenge.callback(tags.map(function(t){ return {"id":t.id, "html":t.name}; }));
  });
});

$(document).on('lozenge:store', function(event, lozenge) {
  lozenge.preventDefault();
  $.post(TAGS_URI, {'tag':{'name':lozenge.value}}, function(tag) {
    lozenge.callback({"id":tag.id, "html":tag.name});
  });
});
