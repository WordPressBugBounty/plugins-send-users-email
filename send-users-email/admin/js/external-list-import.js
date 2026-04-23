(function ($) {
    'use strict';
    // handles the external list upload and process in form
    // this uses jquery ajax with chunk processing for large files and progress bar
    
    var importExternalList = (function() {
        // private variables and functions can be defined here if needed
        var cancel_import = false;
        var nonce = $('input[name="sue_external_lists_nonce"]').val();
        var global_form = $('#sue-externali-list-import-form');

        function _test() {
            console.log('test');
        }

        function mock_button_handler() {
            $('#test-chunk-btn').on('click', function() {
                console.log('Mock chunk processing started');
                cancel_import = false;
                $('#status-text').text('Starting mock import...');
                $('#progress-bar').css('width', '0%');
                $('#cancel-btn').show().off('click').on('click', function() {
                    cancel_import = true;
                    $('#status-text').text('Mock import canceled.');
                });
                console.log(nonce);
                var totalChunks = 20; // Simulate 20 chunks
                runChunkedProcess({
                    action: 'mock_chunk_process',
                    totalChunks: totalChunks,
                    extraData: {nonce: nonce}
                });
            });
        }

        function import_list_button_handler() {
            // Implementation for real import button handler can go here
            $('#sue-externali-list-import-form').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                $('#status-text').text('Uploading file...');
                $('#progress-bar').css('width', '0%');
                $('#cancel-btn').hide();

                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            $('#status-text').text('File uploaded. Starting import...');
                            $('#cancel-btn').show().off('click').on('click', function() {
                                cancelImport = true;
                                $('#status-text').text('Import canceled.');
                            });

                            // Call reusable chunk processor for real import
                            runChunkedProcess({
                                action: 'process_external_import_chunk',
                                totalChunks: Math.ceil(response.data.import.row_count / 500),
                                chunkSize: 500,
                                extraData: {
                                    file_path: response.data.import.file_path,
                                    list_name: $('#external_list_name').val(),
                                    nonce: $('input[name="sue_external_lists_nonce"]').val()
                                }
                            });
                        } else {
                            $('#status-text').text('Error: ' + response.data.message);
                        }
                    },
                    error: function() {
                        $('#status-text').text('Upload failed.');
                    }
                });
            });
        }

        // Reusable chunked process function
        function runChunkedProcess(config) {
            var currentChunk = 0;
            var totalInserted = 0;

            function processChunk() {
                if (cancel_import) return;

                var isLastChunk = (currentChunk === config.totalChunks - 1);
                var data = {
                    action: config.action,
                    chunk_index: currentChunk,
                    total_chunks: config.totalChunks,
                    file_path: config.file_path,
                };

                // Merge extra data for real import
                $.extend(data, config.extraData);
                if (config.action === 'process_external_import_chunk') {
                    data.is_last_chunk = isLastChunk;
                    data.total_inserted = totalInserted;
                }

                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        if (response.success) {
                            totalInserted += response.data.import.inserted_count || 0;
                            currentChunk++;
                            var progress = Math.round((currentChunk / config.totalChunks) * 100);
                            $('#progress-bar').css('width', progress + '%');
                            $('#status-text').text('Processing chunk ' + currentChunk + ' of ' + config.totalChunks);

                            if (currentChunk < config.totalChunks && !cancel_import) {
                                processChunk();
                            } else if (!cancel_import) {
                                $('#status-text').text(
                                    (config.action === 'mock_chunk_process')
                                        ? 'Mock import completed! Total inserted: ' + totalInserted
                                        : 'Import completed: ' + totalInserted + ' rows inserted.'
                                );
                                $('#cancel-btn').hide();
                                global_form[0].reset();
                                
                                // reset everything but slowly fade out progress bar
                                setTimeout(function() {
                                    $('#progress-bar').css('width', '0%');
                                    // self reload to reset state
                                    location.reload();
                                }, 2000);

                            }
                        } else {
                            $('#status-text').text('Error: ' + response.data.message);
                        }
                    },
                    error: function() {
                        $('#status-text').text('Processing failed.');
                    }
                });
            }

            processChunk();
        }

        return {
            // public methods can be defined here if needed
            test: mock_button_handler,
            import: import_list_button_handler
        };
    })();

     var delete_external_list = (function() {
        function init() {
            $('.sue-delete-external-list-btn').on('click', function(e) {
                e.preventDefault();
                if (!confirm('Are you sure you want to delete this external list? This action cannot be undone.')) {
                    return;
                }
                var list_id = $(this).data('list-id');
                var nonce = $(this).data('nonce');
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'sue_delete_external_list',
                        list_id: list_id,
                        nonce: nonce
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('External list deleted successfully.');
                            location.reload();
                        } else {
                            alert('Error: ' + response.data.message);
                        }
                    },
                    error: function() {
                        alert('Request failed.');
                    }
                });
            });
        }

        return {
            init: init
        };
     })();

    var edit_external_list = (function() {
        function init() {
            $('.sue-edit-external-list-btn').on('click', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                window.location.href = url;
            });
        }

        return {
            init: init
        };
     })();

    jQuery(document).ready(function($) {
        //importExternalList.test();
        importExternalList.import();
        delete_external_list.init();
        edit_external_list.init();
    });

})(jQuery);