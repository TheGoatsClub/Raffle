(function ($) {
    $(document).ready(function () {

        const uploader = wp.media({
            title: 'Select an Image',
            button: {
                text: 'Use this Image'
            },
            multiple: false
        });

        uploadImage();

        uploader.on('select', function () {
            let imageTarget = document.querySelector('.raffle_repeater__body.popup-open');

            if (!imageTarget) {
                return;
            }

            let imageItem = imageTarget.querySelector('.raffle_img_item');
            let btnRemove = imageTarget.querySelector('.raffle_attachment_remove');
            let imageData = imageTarget.querySelector('.raffle_attachment_id');
            let img = '';
            let attachment = uploader.state().get('selection').first().toJSON();

            if (!imageItem.children.length) {
                img = document.createElement('img');
            } else {
                img = imageItem.querySelector('img');
            }

            img.src = attachment.url;
            img.alt = attachment.alt;

            img.setAttribute('width', '350');
            img.setAttribute('height', '200');
            img.style.objectFit = 'contain';

            if (!imageItem.children.length) {
                imageItem.appendChild(img);
            }

            if (btnRemove && btnRemove.classList.contains('hidden')) {
                btnRemove.classList.remove('hidden');
            }

            if (imageData) {
                imageData.value = attachment.id;
            }

            if (imageTarget.parentNode.classList.contains('popup-open')) {
                imageTarget.parentNode.classList.remove('popup-open');
            }
        });

        const mediaList = document.querySelector('.raffle_repeater__list');
        const mediaItemAdd = document.querySelector('.raffle_media_add');
        if (mediaList && mediaItemAdd) {
            mediaItemAdd.addEventListener('click', function () {
                const item = document.createElement('div');
                const newItem = `
                <div class="raffle_repeater__body">
                    <p class="raffle_img_item"></p>
                    <span class="raffle_attachment_add button">Add image</span>
                    <span class="raffle_attachment_remove button hidden">Remove image</span>
                    <input type="hidden" class="raffle_attachment_id button" name="raffle_attachments[]" value="">
                </div>`;

                item.classList.add('raffle_repeater__item');
                item.innerHTML = newItem;
                mediaList.append(item);

                uploadImage();
            });
        }

        function uploadImage()
        {
            const imageThumbnails = document.querySelectorAll('.raffle_repeater__body');
            if (imageThumbnails) {
                imageThumbnails.forEach((item) => {
                    let image = item.querySelector('.raffle_img_item');
                    let imageData = item.querySelector('.raffle_attachment_id');
                    let btnAdd = item.querySelector('.raffle_attachment_add');
                    let btnRemove = item.querySelector('.raffle_attachment_remove');

                    if (!image || !imageData || !btnAdd || !btnRemove) {
                        return;
                    }

                    if (btnAdd) {
                        btnAdd.addEventListener('click', function () {
                            if (!uploader) {
                                return;
                            }

                            clearImagesState();

                            if (!this.parentNode.classList.contains('popup-open')) {
                                this.parentNode.classList.add('popup-open');
                            }

                            uploader.open();
                        });
                    }

                    if (btnRemove) {
                        btnRemove.addEventListener('click', function () {
                            if (image) {
                                image.innerHTML = '';
                            }

                            if (imageData) {
                                imageData.value = '';
                            }

                            this.classList.add('hidden');
                        });
                    }
                });
            }
        }

        function clearImagesState() {
            const imageThumbnails = document.querySelectorAll('.raffle_repeater__body');

            imageThumbnails.forEach((img) => {
                if (img.classList.contains('popup-open')) {
                    img.classList.remove('popup-open');
                }
            });
        }

    });
})(jQuery);