/**
 * Created by S3b0 on 10/12/15.
 */

function setAttribute(selector, attribute, unset, value) {
    if (unset) {
        $(selector).removeAttr(attribute);
    } else {
        $(selector).attr(attribute, value);
    }
}

$(document).ready(function($) {
    var states    = [],
        selector = $('#prf-enduser-state-selector #prf-enduser-state'),
        mandatory = $('#prf-enduser-state-selector .mandatory');

    /**
     * Write option contents to Array
     */
    $('#prf-enduser-state-selector #prf-enduser-state option').each(function() {
        if ($(this).val()) {
            states.push({
                'label': $(this).html(),
                'value': $(this).val(),
                'country': $(this).data('country')
            });
        }
    });

    /**
     * Initializes the 'Control-Country-State-Relation'
     */
    function initCCSR() {
        mandatory.hide();
        selector.html('');
        selector.attr('disabled', 'disabled');
    }

    /**
     * Initialize ParsleyJS
     */
    function initParsley() {
        $('.tx-project-registration').parsley();
    }

    /**
     * Bind onchange function to country selector
     */
    $('#prf-enduser-country-selector #prf-enduser-country').on('change', function() {
        var value = $(this).val();

        initCCSR();

        /**
         * Walk through states to fetch and append those available to state selector, if any
         */
        $.each(states, function() {
            if (this.country == value) {
                selector.append('<option value="' + this.value + '">' + this.label + '</option>');
            }
        });

        /**
         * If any states available, make state selector required and bind empty value option to make validation work
         */
        if ($('#prf-enduser-state-selector #prf-enduser-state option').length) {
            mandatory.show();
            selector.prepend('<option value="" selected="selected"></option>');
            selector.attr('required', 'required');
            selector.attr('data-parsley-required', 'true');
            selector.removeAttr('disabled');
        } else {
            selector.prepend('<option value="0" selected="selected"></option>');
            selector.removeAttr('required');
            selector.removeAttr('data-parsley-required');
        }
        initParsley();
    });

    /**
     * Display property selections depending on given product
     */
    $('select#prf-product').on('change', function() {
        $('.prf-property-selector').each(function() {
            $(this).hide();
            if ($(this).hasClass('prf-form-type-radio')) {
                setAttribute('#' + $(this).attr('id') + ' input[type="radio"]', 'required', true, '');
            }
            if ($(this).hasClass('prf-form-type-select')) {
                setAttribute('#' + $(this).attr('id') + ' select', 'required', true, '');
            }
        });
        var selected = $(this).children('option:selected');
        if (selected.length === 1 && selected.first().data('properties')) {
            var properties = selected.first().data('properties'),
                propertyValues = [];
            if (properties.indexOf(',') !== -1) {
                propertyValues = properties.split(',');
            } else {
                propertyValues.push(properties);
            }

            $.each(propertyValues, function(index, value) {
                var propertyDiv = $(value);
                propertyDiv.show();
                if (propertyDiv.hasClass('prf-form-type-radio')) {
                    setAttribute(value + ' input[type="radio"]', 'required', false, 'required');
                }
                if (propertyDiv.hasClass('prf-form-type-select')) {
                    setAttribute(value + ' select', 'required', false, 'required');
                }
            });
        }
    });

    initCCSR();
    initParsley();
});