(function ($) {
    'use strict';

    var update_list = (function() {
        const $table = $('#external-list-edit-table');
        const editingClass = 'editing';

        /**
         * Purpose of this function is to store the original text of the row before converting it into edit mode. 
         * This is useful when the user clicks the cancel button and we need to revert back to the original text.
         * The original text is stored in the data attribute of the input or select element when the user clicks the edit button.
         * The function will loop through the array of class to convert and get the original text from the cell and store it in the data attribute of the input or select element.
         * The function will be called when the user clicks the edit button and we need to store the original text before converting it into edit mode.
         * The function will be called in the toggleEditMode function after toggling the edit mode. This is because we need to toggle the edit mode first before storing the original text because the input fields will be created when we toggle the edit mode and we need to store the original text in the data attribute of the input fields.
         * The function will check the type of input field and store the original text accordingly. If it is a select field then it will store the text of the selected option as the original text. If it is an input field then it will store the value of the input field as the original text.
         * The function will be called when the user clicks the edit button and we need to store the original text before converting it into edit mode.
         * The function will be called in the toggleEditMode function after toggling the edit mode. This is because we need to toggle the edit mode first before storing the original text because the input fields will be created when we toggle the edit mode and we need to store the original text in the data attribute of the input fields.
         * The function will check the type of input field and store the original text accordingly. If it is a select field then it will store the text of the selected option as the original text. If it is an input field then it will store the value of the input field as the original text.
         * The function will be called when the user clicks the edit button and we need to store the original text before converting it into edit mode.
         *   
         * @param {*} $row 
         * @param {*} $array_of_class_to_convert 
         */
        function storeOriginalText($row, $array_of_class_to_convert) 
        {
            $array_of_class_to_convert.forEach(function(item) {
                const $cell = $row.find('.' + item.class_name).find('input, select');
                let original_text;
                if (item.input_type === 'select') {
                    original_text = $cell.find('option:selected').text().trim();
                } else {
                    original_text = $cell.val().trim();
                }
                console.log('Storing original text for cell with class ' + item.class_name + ': ' + original_text);
                // store the original text in the data-original-text attribute so it persists in the DOM.
                $cell.attr('data-original-text', original_text);
            });
        }

        /**
         * Purpose of this function is to restore the original text of the row when the user clicks the cancel button.
         * This function will get the original text from the data attribute and set it back to the cell.
         * This function is called when the user clicks the cancel button and we need to revert back to the original text.
         * The original text is stored in the data attribute of the input or select element when the user clicks the edit button.
         * The function will loop through the array of class to convert and get the original text from the data attribute and set it back to the cell.
         * The function will check the type of input field and set the value accordingly. If it is a select field then it will set the value of the select field to the original text. If it is an input field then it will set the value of the input field to the original text.
         * The function will be called when the user clicks the cancel button and we need to revert back to the original text.
         * The function will be called in the cancelEditMode function after converting the row back to view mode.
         * This is because we need to convert the row back to view mode before setting the original text back to the cell. If we set the original text back to the cell before converting it back to view mode then it will not work because the input fields will still be there and we need to remove them first before setting the original text back to the cell.
         *  
         * @param {*} $row 
         * @param {*} $array_of_class_to_convert 
         */
        function restoreOriginalText($row, $array_of_class_to_convert) 
        {
            $array_of_class_to_convert.forEach(function(item) {
                const $cell = $row.find('.' + item.class_name);
                const $original_text = $cell.data('original-text');
                console.log('Restoring original text for cell with class ' + item.class_name + ': ' + $original_text);
                // restore it to table row cell text and not the input field because we have already converted the row back to view mode in the cancelEditMode function.
                $cell.text($original_text);
            });
        }

        function removeDataAttribute($row, $array_of_class_to_convert, $data_attribute_name) 
        {
            $array_of_class_to_convert.forEach(function(item) {
                const $cell = $row.find('.' + item.class_name);
                $cell.removeAttr($data_attribute_name);
            });
        }

        /**
         * @param {*} $row 
         * Toggle the row to edit mode.
         * If a row has a class editing then call the cancel button and toggle the edit mode.
         * When editing, the row should convert into input or html forms.
         */ 
        function toggleEditMode($row)
        {
            const is_there_editing_row = $table.find('tr.' + editingClass).length > 0;

            if (is_there_editing_row) {
                const $editing_row = $table.find('tr.' + editingClass);
                
                const $cancel_btn = $editing_row.find('.sue-cancel-edit-btn');
                $cancel_btn.trigger('click');

            }

            $row.toggleClass(editingClass);
        }

        function showSaveCancelButtons($row) {
            const $actionsCell = $row.find('td.actions');
            const $existingButtons = $actionsCell.find('.sue-delete-external-list-btn, .sue-edit-external-list-btn');

            // Hide default edit/delete controls while row is in edit mode.
            $existingButtons.addClass('d-none');

            const $save_btn = $('<button type="button" class="sue-btn sue-btn-primary sue-btn-icon sue-save-external-list-btn"><span class="dashicons dashicons-yes"></span></button>')
                .addClass('sue-save-edit-btn');

            const $cancel_btn = $('<button type="button" class="sue-btn sue-btn-muted sue-btn-icon sue-cancel-external-list-btn"><span class="dashicons dashicons-no"></span></button>')
                .addClass('sue-cancel-edit-btn');

            $actionsCell.append('<div class="sue-edit-actions-btn-container"></div>');
            $actionsCell.find('.sue-edit-actions-btn-container').append($save_btn, $cancel_btn);
        }

        function hideSaveCancelButtons($row) {
            const $edit_actions_btn_container = $row.find('.sue-edit-actions-btn-container');

            $edit_actions_btn_container.remove();
            $row.find('.sue-delete-external-list-btn, .sue-edit-external-list-btn').removeClass('d-none');
        }

        function cancelEditMode($row) {
            hideSaveCancelButtons($row);
            $row.removeClass(editingClass);
        }

        function convertRowToEditMode($row, $array_of_class_to_convert) 
        {
            // store original text and replace with input fields.
            // find certain class in the row and replace the text with input field and set the value of the input field to the original text.
            $array_of_class_to_convert.forEach(function(item) {
                const $cell = $row.find('.' + item.class_name);
                const original_text = $cell.text().trim();
                let $input;
                if (item.input_type === 'select') {
                    $input = $('<select name="' + item.class_name + '">').addClass('form-control');
                    item.options.forEach(function(option) {
                        const $option = $('<option>').val(option.value).text(option.text);
                        if (option.text === original_text) {
                            $option.attr('selected', 'selected');
                        }
                        $input.append($option);
                    });
                } else if (item.input_type === 'email') {
                    $input = $('<input name="' + item.class_name + '">')
                        .attr('type', 'email')
                        .addClass('form-control')
                        .val(original_text);
                } else {
                    $input = $('<input name="' + item.class_name + '">')
                        .attr('type', item.input_type)
                        .addClass('form-control')
                        .val(original_text);
                }

                $cell.attr('data-original-text', original_text);
                $cell.empty().append($input);
            });
            
        }
        
        function convertRowToViewMode($row, $array_of_class_to_convert)
        {
            // find the input fields in the row and replace with text.
            $array_of_class_to_convert.forEach(function(item) {
                const $cell = $row.find('.' + item.class_name);
                let $input;
                if (item.input_type === 'select') {
                    $input = $cell.find('select');
                } else if (item.input_type === 'email') {
                    $input = $cell.find('input[type="email"]');
                } else {
                    $input = $cell.find('input');
                }
                const input_value = $input.val();

                // need to check what type of input field it is. If it is select then get the text of the selected option instead of the value.
                if (item.input_type === 'select') {
                    const selected_option_text = $input.find('option:selected').text();
                    $cell.empty().text(selected_option_text);
                    return;
                } else if (item.input_type === 'email') {
                    $cell.empty().text(input_value);
                    return;
                }

                $cell.empty().text(input_value);
            });
        }

        function handleSaveButtonClick($row, $id, $array_of_class_to_convert) 
        {
            // create an object to store the updated values of the fields.
            const updated_data = {
                id: $id
            };

            // loop through the array of class to convert and get the value of the input fields and store in the updated_data object.
            $array_of_class_to_convert.forEach(function(item) {
                let $input;
                if (item.input_type === 'select') {
                    $input = $row.find('.' + item.class_name).find('select');
                } else if (item.input_type === 'email') {
                    $input = $row.find('.' + item.class_name).find('input[type="email"]');
                } else {
                    $input = $row.find('.' + item.class_name).find('input');
                }
                const input_value = $input.val();
                updated_data[item.class_name] = input_value;
            });

            var $nonce = sueExternalListEdit.nonce;
            
            // send ajax request to update the external list.
            $.ajax({
                url: sueExternalListEdit.ajaxUrl,
                method: 'POST',
                data: {
                    action: 'sue_update_external_list',
                    data: updated_data,
                    security: $nonce
                },
                success: function(response) {
                    if (response.success) {
                        // update the text with the new value and convert the row back to view mode.
                        progress_loader.hide($row);
                        alert('External list updated successfully.');
                    } else {
                        alert('Failed to update the external list. Please try again.');
                    }
                },
                error: function() {
                    alert('An error occurred while updating the external list. Please try again.');
                }
            });
        }

        function init() {
            //console.log('External List Edit JS initialized');
            // create a multiple array variable to decide what class to convert into input field and what type of input field to create. For example, if the class is .list-name then create a text input field and set the value to the original text.
            const $array_of_class_to_convert = [
                {
                    class_name: 'email',
                    input_type: 'email'
                },
                {
                    class_name: 'first_name',
                    input_type: 'text'
                },
                {
                    class_name: 'last_name',
                    input_type: 'text'
                },
                {
                    class_name: 'title',
                    input_type: 'text'
                },
                {
                    class_name: 'salutation',
                    input_type: 'text'
                },
                {
                    class_name: 'field_01',
                    input_type: 'text'
                },
                {
                    class_name: 'field_02',
                    input_type: 'text'
                },
                {
                    class_name: 'field_03',
                    input_type: 'text'
                },
                {
                    class_name: 'field_04',
                    input_type: 'text'
                },
                {
                    class_name: 'field_05',
                    input_type: 'text'
                },
                {
                    class_name: 'subscribed',
                    input_type: 'select',
                    options: [
                        { value: '1', text: 'Yes' },
                        { value: '0', text: 'No' }
                    ]
                }
            ];

            $table.on('click', '.sue-edit-external-list-btn', function() {
                const $row = $(this).closest('tr');

                // If already editing, treat the second click as save to match previous UX.
                if ($row.hasClass(editingClass)) {
                    $row.find('.sue-save-external-list-btn').trigger('click');
                    return;
                }

                toggleEditMode($row);
                showSaveCancelButtons($row);
                convertRowToEditMode($row, $array_of_class_to_convert);
                storeOriginalText($row, $array_of_class_to_convert);
                
            });

            $table.on('click', '.sue-cancel-external-list-btn', function() {
                const $row = $(this).closest('tr');

                cancelEditMode($row);
                convertRowToViewMode($row, $array_of_class_to_convert);
                restoreOriginalText($row, $array_of_class_to_convert);
                removeDataAttribute($row, $array_of_class_to_convert, 'data-original-text');
            });

            
            $table.on('click', '.sue-save-external-list-btn', function() {
                const $row = $(this).closest('tr');
                const external_list_id = $row.data('id');

                progress_loader.show($row, 'update');
                handleSaveButtonClick($row, external_list_id, $array_of_class_to_convert);
                convertRowToViewMode($row, $array_of_class_to_convert);
                removeDataAttribute($row, $array_of_class_to_convert, 'data-original-text');
                cancelEditMode($row);
            });
        }

        return {
            init: init
        };
     })();

     var delete_list = (function() {
        const $table = $('#external-list-edit-table');

        function init() {
            $table.on('click', '.sue-delete-external-list-btn', function() {
                const $row = $(this).closest('tr');
                const list_id = $row.data('id');
                const nonce = $(this).data('nonce');
                $row.addClass('deleting');

                console.log('Delete button clicked for list ID: ' + list_id);
                console.log('Nonce for deletion: ' + nonce);
                if (confirm('Are you sure you want to delete this entry?')) {
                    console.log('List ID to delete: ' + list_id);
                    progress_loader.show($row, 'delete');
                    // send ajax request to delete the external list.
                    $.ajax({
                        url: sueExternalListEdit.ajaxUrl,
                        method: 'POST',
                        data: {
                            action: 'sue_remove_external_list',
                            list_id: list_id,
                            security: nonce
                        },
                        success: function(response) {
                            if (response.success) {
                                alert('External list entry deleted sucessfully.');
                                progress_loader.hide($row);
                                $row.remove();
                            } else {
                                alert('Failed to delete the external list. Please try again.');
                            }
                        },
                        error: function() {
                            alert('An error occurred while deleting the external list. Please try again.');
                        }
                    });
                }
                $row.removeClass('deleting');
            });
        }

        return {
            init: init
        };
     })();

     var search_filter = (function() {
        var $search_input = $('#external-list-search');
        var $table_body = $('#external-list-edit-table-body');
        var $match_count = $('#matchCount');
        var $rows = $table_body.find('tr').not('.no-results-row');
        var $empty_row_class = $('.no-results-row');

        // Normalize: lowercase + strip diacritics
        var normalize = function(str) {
            str = (str || '').toString().toLowerCase();
            if(str.normalize) {
                str = str.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
            }
            return str;
        }

        function init() {
            if ($search_input.length === 0) {
                return;
            }

            // Cache normalized hay for each row (from data-hay OR data-content fallback)
            $rows.each(function() {
                let $row = $(this);
                let haystack = $row.attr('data-hay') || $row.attr('data-content') || $row.text();
                $row.data('hay', normalize($.trim(haystack)));
            });

            var t = null;
            var delay = 150; // debounce delay in ms

            var filter = function() {
                let raw = $.trim($search_input.val());
                let term = normalize(raw);
                let tokens = term ? term.split(/\s+/).filter(Boolean) : [];
                let matches = 0;

                if (!tokens.length) {
                    $rows.removeClass('d-none');
                    $empty_row_class.addClass('d-none');
                    $match_count.text($rows.length + ' rows ' );

                    return;
                }

                $rows.each(function() {
                    let $row = $(this);
                    let hay = $row.data('hay') || '';
                    let ok = true;
                    for (let i = 0; i < tokens.length; i++) {
                        if (hay.indexOf(tokens[i]) === -1) {
                            ok = false;
                            break;
                        }
                    }
                    $row.toggleClass('d-none', !ok);
                    if (ok) matches++;
                });

                $empty_row_class.toggleClass('d-none', matches !== 0);
                $match_count.text(matches + ' match' + (matches !== 1 ? 'es' : '') + ' for "' + raw + '"');
            }

            $search_input.on('input keyup change', function() {
                clearTimeout(t);
                t = setTimeout(filter, delay);
            });

            // initialize render
            filter();
        }

        return {
            init: init
        };

     })();

    var progress_loader = (function() {
        function show($row, $action) {
            console.log('Checking if row has editing class: ' + $row.hasClass('editing'));
            if($row.hasClass('editing') || $row.hasClass('deleting')) {
                console.log('Showing progress loader');
                console.log($action);
                $row.addClass('sue-isbusy sue-progress-' + $action);
                const $legacyActionWrap = $row.find('.action-btn');
                if ($legacyActionWrap.length > 0) {
                    $legacyActionWrap.addClass('d-none');
                } else {
                    $row.find('.actions .sue-btn, .actions a').addClass('d-none');
                }
                $row.find('.actions').append('<span id="sue-progress-loader" class="spinner is-active"></span>');
            }           
        }

        function hide($row) {
            console.log('Hiding progress loader');
            $row.removeClass('sue-isbusy sue-progress-update sue-progress-delete');
            const $legacyActionWrap = $row.find('.action-btn');
            if ($legacyActionWrap.length > 0) {
                $legacyActionWrap.removeClass('d-none');
            } else {
                $row.find('.actions .sue-btn, .actions a').removeClass('d-none');
            }
            $row.find('#sue-progress-loader').remove();
        }

        return {
            show: function($row, $action) {
                show($row, $action);
            },
            hide: function($row) {
                hide($row);
            }
        };
     })();

    jQuery(document).ready(function($) {
        update_list.init();
        delete_list.init();
        search_filter.init();
    });

})(jQuery);