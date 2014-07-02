(function($) {

  function selectOption(value, forced) {
    var container = this;
    var options = this.data('options');
    var inputName = this.data('inputName');
    for (var i=0; len=options.length,i<len; i++) {
      if (options[i].id == value) {
        if (options[i].selected && !forced) return;

        options[i].selected = true;
        this.data('options', options);

        var option = $('<span />', {'data-id':options[i].id, 'data-selected':options[i].selected, 'data-token-item':true, 'class':'token-item'});
        option.html(options[i].html);
        var input = $('<input />', {'type':'hidden', 'name':inputName, 'value':options[i].id});
        option.append(input);
        var remove = $('<a href="#" data-remove class="token-item-remove">&times;</a>');
        option.append(remove);
        container.append(option);
      }
    }
    return this;
  }

  $.fn.token = function(options) {

    if (options == 'selectOption') {
      var args = Array.prototype.slice.call(arguments, 1);
      return selectOption.apply(this, args);
    }

    var opts = $.extend( {}, $.fn.token.defaults, options );
    return this.each(function() {
      var inputName = $(this).attr('name');
      var inputId = $(this).attr('id');

      $(this).hide();
      $(this).removeAttr('name');
      $(this).removeAttr('id');

      var options = [];
      $(this).find('option').each(function() {
        options.push({id: $(this).attr('value'), html:$(this).html(), selected:$(this).attr('selected')?true:false});
      });

      var container = $('<span />', {name: inputName, id: inputId, 'data-token-field':true, 'class':'token-field'});
      container.data('options', options);
      container.data('inputName', inputName);
      container.data('originalInput', $(this));

      for (var i=0; len=options.length,i<len; i++) {
        if (options[i].selected) {
          container.token('selectOption', options[i].id, true);
        }
      }

      var input = $('<input type="text" data-token-input class="token-input" />');
      input.attr('id', inputId);
      $(container).append(input);

      $(this).after(container);
    });
  }

  $.fn.token.defaults = {
    color: "#556b2f",
    backgroundColor: "white"
  }

  $('[data-token]').token();

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
    var input = $(this);
    var field = input.closest('[data-token-field]');
    var options = field.data('options');

    var lozenge = {
      defaultPrevented: false,
      preventDefault: function() {
        lozenge.defaultPrevented = true;
      },
      callback: function(fetchedOptions) {
        var optionList = $('<ul />', {'data-token-optionList':true, 'class':'token-optionList'});
        for (var i=0; len=fetchedOptions.length, i<len; i++) {
          var listItem = $('<li />', {'data-value':fetchedOptions[i].id, 'data-token-option':true, 'class':'token-option'});
          if (fetchedOptions[i].text) { listItem.text(fetchedOptions[i].text); }
          if (fetchedOptions[i].html) { listItem.html(fetchedOptions[i].html); }
          optionList.append(listItem);
        }
        input.after(optionList);
      }
    }

    field.data('originalInput').trigger('lozenge:fetch', lozenge);
    if (lozenge.defaultPrevented == false) {
      lozenge.callback(options);
    }
  });

  $(document).on('blur', '[data-token-input]', function() {
    setTimeout(function() {
      $('[data-token-optionList]').remove();
    }, 500);
  });

  $(document).on('click', '[data-token-option]', function() {
    $(this).closest('[data-token-field]').token('selectOption', $(this).data('value'));
    return false;
  });

  $(document).on('keyup', '[data-token-input]', function(event) {
    var val = $(this).val();
    if (val === '') {
      $('[data-token-newOption]').remove();
      return;
    }

    var newOption = $('[data-token-newOption]');
    if (!newOption.length) {
      var newOption = $('<li data-token-newOption class="token-newOption" />').prependTo('[data-token-optionList]');
    }
    newOption.data('value', val);
    newOption.html(val);

    if (event.keyCode == 13) {
      return false;
    }
  });

  $(document).on('click', '[data-token-newOption]', function() {
    var container = $(this).closest('[data-token-field]');

    var lozenge = {
      value: $(this).data('value'),
      defaultPrevented: false,
      preventDefault: function() {
        lozenge.defaultPrevented = true;
      },
      callback: function(newOption) {
        var options = container.data('options');
        options.push({id:newOption.id, html:newOption.html, selected:false});
        container.data('options', options);
        container.token('selectOption', newOption.id);
      }
    }

    container.data('originalInput').trigger('lozenge:store', lozenge);
  });

})(jQuery);
