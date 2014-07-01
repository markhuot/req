//= require ./token.js

$(document.body).removeClass('preload');

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
