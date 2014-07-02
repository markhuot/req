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

  $(document).on('focus keyup', '[data-token-input]', function() {
    var input = $(this);
    var field = input.closest('[data-token-field]');
    var options = field.data('options');

    var optionList = field.find('[data-token-optionList]');
    if (!optionList.length) {
      optionList = $('<ul />', {'data-token-optionList':true, 'class':'token-optionList'});
      input.after(optionList);
    }

    var lozenge = {
      value: $(this).val(),
      defaultPrevented: false,
      preventDefault: function() {
        lozenge.defaultPrevented = true;
      },
      createOption: function(value) {
        if (value) {
          var listItem = optionList.find('[data-token-newOption]');
          if (!listItem.length) {
            listItem = $('<li />', {'data-id':'null', 'data-value':value, 'data-token-option':true, 'data-token-newOption':true, 'class':'token-newOption'});
            optionList.prepend(listItem);
          }
          listItem.data('value', value);
          listItem.text(value);
        }
        else {
          $('[data-token-newOption]').remove();
        }
      },
      addOption: function(option) {
        var listItem = optionList.find('[data-value="'+option.id+'"]');
          if (!listItem.length) {
            listItem = $('<li />', {'data-value':option.id, 'data-token-option':true, 'class':'token-option'});
            if (option.text) { listItem.text(option.text); }
            if (option.html) { listItem.html(option.html); }
            optionList.append(listItem);
          }
      },
      addOptions: function(fetchedOptions) {
        for (var i=0; len=fetchedOptions.length, i<len; i++) {
          lozenge.addOption(fetchedOptions[i])
        }
      }
    }

    field.data('originalInput').trigger('lozenge:fetch', lozenge);
    if (lozenge.defaultPrevented == false) {
      lozenge.addOptions(options);
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

  $(document).on('click', '[data-token-newOption]', function() {
    var container = $(this).closest('[data-token-field]');

    var lozenge = {
      id: $(this).data('id'),
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
