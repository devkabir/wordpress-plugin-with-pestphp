jQuery(
    function ($) {
        /* It selects the body element. */
        const body = $('body');
        /* A notification library. */
        const notyf = new Notyf();
        /* A flag to prevent multiple ajax request. */
        let ajaxing = false;

        const toggleSubmit = () => $('input.slide-selections').serializeArray().length > 0 ? $('#submit').show() : $('#submit').hide();
        toggleSubmit();
        /* It open the media uploader. */
        body.on(
            'click',
            '.slide-upload',
            function (event) {
                event.preventDefault();
                const customUploader = wp.media(
                    {
                        title: 'Insert image',
                        library: {
                            type: 'image'
                        },
                        button: {
                            text: 'Use this image'
                        },
                        multiple: true,
                    }
                ).on(
                    'select',
                    function () {
                        $("#selected-slides").empty();
                        customUploader.state().get('selection').toJSON().map(function (item) {
                            $("#selected-slides")
                                .append(`<li id="slide-selection-${item.id}">
                                            <input type="hidden" class="slide-selections" name="wordpress_slideshow_slides[]" value="${item.id}"/>
                                            <img src="${item.url}" alt="${item.id}"/> 
                                            <span class="dashicons dashicons-trash remove-selection" data-image="${item.id}"></span> 
                                         </li>`);
                        });
                        toggleSubmit();
                    }
                )
                // already selected images
                customUploader.on(
                    'open',
                    function () {
                        $('input.slide-selections').serializeArray().map(i => {
                            const selection = customUploader.state().get('selection')
                            let attachment = wp.media.attachment(i.value);
                            attachment.fetch();
                            selection.add(attachment ? [attachment] : []);
                        })

                    }
                )
                customUploader.open()
            }
        );

        /* It makes the slides sortable. */
        $("#wordpress-slides-sort").sortable({
            axis: 'y',
            opacity: 0.6,
            update: function (event, ui) {
                const data = '&slide_nonce_1=' + $('#slide-nonce-1').val() + '&' + $(this).sortable('serialize');
                slideshow_ajax(data);
            }
        });
        $("#selected-slides").sortable({
            axis: 'y',
            opacity: 0.6,
        })


    }
);
