(function($) {

  function OptionList() {
    this.containers = [];
    this.options = [];
  }

  OptionList.prototype.createOption = function(label) {
    return this;
  }

  OptionList.prototype.addOption = function(key, label) {
    this.options.push({'key':key, 'label':label});
    return this;
  }

  OptionList.prototype.addOptions = function(options) {
    for (var i=0,len=options.length; i<len; i++) {
      this.addOption(options[i]);
    }
    return this;
  }

  OptionList.prototype.clearOptions = function() {
    this.options = [];
  }

  OptionList.prototype.find = function(key) {
    for (var i=0,len=this.options.length; i<len; i++) {
      if (this.options[i].key === key) {
        return this.options[i];
      }
    }
    return false;
  }

  OptionList.prototype.attach = function(container) {
    this.containers.push(container);
  }










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
        container.find('[data-token-input]').before(option);
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

      var container = $('<span />', {name: inputName, 'data-token-field':true, 'class':'token-field'});
      container.data('inputName', inputName);
      container.data('originalInput', $(this));
      container.data('optionList', new OptionList);

      var options = [];
      $(this).find('option').each(function() {
        container.data('optionList').addOption($(this).attr('value'), $(this).html());
        options.push({id: $(this).attr('value'), html:$(this).html(), selected:$(this).attr('selected')?true:false});
      });
      container.data('options', options);

      var input = $('<input type="text" data-token-input class="token-input" />');
      input.attr('id', inputId);
      $(container).append(input);

      for (var i=0; len=options.length,i<len; i++) {
        if (options[i].selected) {
          container.token('selectOption', options[i].id, true);
        }
      }

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
    var container = input.closest('[data-token-field]');
    var options = container.data('options');
    var optionListObj = container.data('optionList');
    optionListObj.attach(container);

    var optionList = container.find('[data-token-optionList]');
    if (!optionList.length) {
      optionList = $('<ul />', {'data-token-optionList':true, 'class':'token-optionList'});
      input.after(optionList);
    }

    var lozenge = {
      value: $(this).val(),
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

        for (var i=0; len=options.length,i<len; i++) {
          if (options[i].id == option.id) {
            return;
          }
        }

        options.push({'id':option.id, 'html':option.html});
        container.data('options', options);
      },
      addOptions: function(fetchedOptions) {
        for (var i=0; len=fetchedOptions.length, i<len; i++) {
          lozenge.addOption(fetchedOptions[i])
        }
      }
    }

    var event = $.Event('lozenge:fetch');
    container.data('originalInput').trigger(event, lozenge);
    if (event.isDefaultPrevented() === false) {
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

    var event = $.Event('lozenge:store');
    container.data('originalInput').trigger(event, lozenge);
  });

})(jQuery);
