$('select[data-chosen]').chosen();
$('input[data-selectTwo]').select2({
  multiple: true,
  query: function (query) {
    var data = {results:[]};
    $.get(TAGS_URI, function(tags) {
      for (var i=0; len=tags.length,i<len; i++) {
        data.results.push({id: tags[i].id, text: tags[i].name});
      }
      query.callback(data);
    });
  },
  createSearchChoice: function(term, data) {
    if ($(data).filter(function() { return this.text.localeCompare(term)===0; }).length===0) {
      $.post(TAGS_URI, {"tag":{"name":term}}, function(tag) {

      });
      return {id:term, text:term};
    }
  }
});

$.fn.selectOption = function(value, forced) {
  var container = this;
  var options = this.data('options');
  var inputName = this.data('inputName');
  for (var i=0; len=options.length,i<len; i++) {
    if (options[i].id == value) {
      if (options[i].selected && !forced) return;

      options[i].selected = true;
      this.data('options', options);

      var option = $('<span />', {'data-id':options[i].id, 'data-selected':options[i].selected, 'data-token-item':true});
      option.html(options[i].html);
      var input = $('<input />', {'type':'hidden', 'name':inputName, 'value':options[i].id});
      option.append(input);
      var remove = $('<a href="#" data-remove>&times;</a>');
      option.append(remove);
      container.append(option);
    }
  }
  return this;
}

$('[data-token]').each(function() {
  var inputName = $(this).attr('name');
  var inputId = $(this).attr('id');

  $(this).hide();
  $(this).removeAttr('name');
  $(this).removeAttr('id');

  var options = [];
  $(this).find('option').each(function() {
    options.push({id: $(this).attr('value'), html:$(this).html(), selected:$(this).attr('selected')?true:false});
  });

  var container = $('<span />', {name: inputName, id: inputId, 'data-token-field':true});
  container.data('options', options);
  container.data('inputName', inputName);
  container.data('inputId', inputId);

  for (var i=0; len=options.length,i<len; i++) {
    if (options[i].selected) {
      container.selectOption(options[i].id, true);
    }
  }

  var input = $('<input type="text" data-token-input />');
  $(container).append(input);

  container.on('keydown', function(event) {
    if (event.keyCode == 13) {
      return false;
    }
  });

  $(this).after(container);
});

$(document).on('click', '[data-token-field] [data-remove]', function() {
  var item = $(this).closest('[data-token-item]');
  var container = $(this).closest('[data-token-field]');
  var options = container.data('options');
  for (var i=0; len=options.length,i<len; i++) {
    if (options[i].id == item.data('id')) {
      options[i].selected = false;
    }
  }
  container.data('options', options);
  $(this).closest('[data-token-field]').find('[data-token-input]').focus();
  $(this).closest('[data-token-item]').remove();
  return false;
});

$(document).on('click', '[data-token-item]', function() {
  $(this).attr('data-selected', true).addClass('selected');
  return false;
});

$(document).on('focus', '[data-token-input]', function() {
  $('[data-token-optionList]').remove();
  var field = $(this).closest('[data-token-field]');
  var options = field.data('options');
  var optionList = $('<ul />', {'data-token-optionList':true});
  for (var i=0; len=options.length, i<len; i++) {
    var listItem = $('<li />', {'data-value':options[i].id, 'data-token-option':true});
    listItem.html(options[i].html);
    optionList.append(listItem);
  }
  $(this).after(optionList);
});

$(document).on('blur', '[data-token-input]', function() {
  setTimeout(function() {
    $('[data-token-optionList]').remove();
  }, 500);
});

$(document).on('click', '[data-token-option]', function() {
  $(this).closest('[data-token-field]').selectOption($(this).data('value'));
  return false;
});

$(document).on('keyup', '[data-token-input]', function() {
  var val = $(this).val();
  if (val === '') {
    $('[data-token-newOption]').remove();
    return;
  }

  var newOption = $('[data-token-newOption]');
  if (!newOption.length) {
    var newOption = $('<li data-token-newOption />').prependTo('[data-token-optionList]');
  }
  newOption.data('value', val);
  newOption.html(val);
});

$(document).on('click', '[data-token-newOption]', function() {
  var container = $(this).closest('[data-token-field]');
  $.post(TAGS_URI, {'text':$(this).data('value')}, function(newOption) {
    var options = container.data('options');
    options.push({id:newOption.id, html:newOption.name, selected:false});
    container.data('options', options);
    container.selectOption(newOption.id);
  })
});
