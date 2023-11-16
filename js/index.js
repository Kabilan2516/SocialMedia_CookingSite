
$(document).ready(function () {
    $.ajax({
        url: '../db/indexing.php',
        method: 'GET',
        data: { function: 'getData' },
        datatype: 'json',
        success: function (response) {
            for (let i = 0; i < response.length; i++) {
                let posts = response[i];
                let cardHtml = `
                    <div class="posts">
                        <div class="card-frame">
                            <div class="card-image">
                                <img id="card-image" src="data:image/png;base64,${posts.image_data}" alt="nature">
                            </div>
                            <h2>${posts.post_title}</h2>
                        </div>
                        <div class="card-footer">
                            <div class="icon-container">
                                <a href="#" data-action="like" data-post-id="${posts.post_id}" data-user-id="${posts.user_id}" class="icon" id="firsticon"><i class="fa-regular fa-heart"></i></a>
                                <a href="#" data-action="comment" data-post-id="${posts.post_id}" data-user-id="${posts.user_id}" class="icon"><i class="fa-regular fa-comment"></i></a>
                                <a href="${posts.media_url}" data-action="link" data-post-id="${posts.post_id}" data-user-id="${posts.user_id}" ><i class="fa-solid fa-link"></i></a>
                            </div>
                        </div>
                    </div>
                `;

                $('.card-body').append(cardHtml);

                // Append the comment popup for each post
                let commentPopupHtml = `
                    <div class="comment-popup" id="commentPopup${posts.post_id}" style="display:none;">
                        <div class="popup-content">
                            <span class="close-comment-popup" id="closePopup">&times;</span>
                            <h2>Comments</h2>
                            <div class="comment-container">
                                <!-- Comment content goes here -->
                            </div>
                            <form id="commentForm">
                                <textarea name="commentText" id="commentText" placeholder="Write Your Comment"></textarea>
                                <button type="submit" class="icon">Submit</button>
                            </form>
                        </div>
                    </div>
                `;

                $('.card-body').append(commentPopupHtml);
            }
        },
        error: function (error) {
            console.log('Error fetching posts:', error);
        }
    });

    // Event listener for comment icon click to show the respective comment popup
    $('.card-body').on('click', '.icon[data-action="comment"]', function (e) {
        e.preventDefault();
        let postId = $(this).data('post-id');
        $(`#commentPopup${postId}`).show();
    });

    // Event listener for closing comment popups
    $('.card-body').on('click', '.close-comment-popup', function (e) {
        e.preventDefault();
        $(this).closest('.comment-popup').hide();
    });



    // using ajax to update the data like comment share
    $('.card-body').on('click', '.icon', function (e) {
        e.preventDefault();

        let action = $(this).data('action');
        console.log(action);
        let postId = $(this).data('post-id');
        let userId = $(this).data('user-id');
        console.log(action);
        // send Ajax requests to update count
        $.ajax({
            url: '../db/indexing.php',
            method: 'POST',
            data: {
                action: action,
                post_id: postId,
                user_id: userId,
                function: 'incressCount'
            },
            success: function (response) {
                console.log('Count updated');
            },
            error: function (error) {
                console.error('Error update count:', error);
            }
        });
    });


    $('#submitForm').click(function (e) {
        e.preventDefault();

        let formData = new FormData(document.getElementById('postForm')); // 'myForm' is the ID of your form
        formData.append('function', 'uplodPostData');
        $.ajax({
            url: '../db/indexing.php', // Replace with your PHP script handling the form data
            type: 'POST',
            data: formData,

            contentType: false,
            processData: false,
            success: function (response) {
                console.log(response); // Log the server response
                // Handle success, e.g., show a success message to the user
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText); // Log any errors
                // Handle errors, e.g., show an error message to the user
            }
        });
    });



});





