<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
@once
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
@endonce
<!-- <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/cropper/2.3.4/cropper.min.css'> -->
<style>
    .box,
    .box-representatives {
        padding: 0.5em;
        width: 100%;
        margin: 0.5em;
    }

    .box-2,
    .box-2-representatives {
        padding: 0.5em;
        width: calc(100%/2 - 1em);
    }

    .hide,
    .hide-representatives {
        display: none;
    }

    img {
        max-width: 100%;
    }
</style>
<div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <div class="mb-4">
                    <h5 class="card-title fw-semibold">{{$alt}}</h5>
                </div>
                @if(Storage::disk($disk)->exists($path.$name.'.png'))
                <img id="basicImg_{{$uuid}}" src="{{Storage::disk($disk)->url($path.$name.'.png')}}" width="200px" height="200px" class="rounded mx-auto d-block" alt="{{$alt}}">
                @else
                <img id="basicImg_{{$uuid}}" src="{{asset('assets/images/profile/user-1.jpg')}}" width="200px" height="200px" class="rounded mx-auto d-block" alt="{{$alt}}">
                @endIf
                <br />
                <form class="form_{{$uuid}}">
                    @csrf
                    <div class="input-group">
                        <input type="hidden" value="{{$name}}" name="id" required />
                    </div>
                    <div class="mb-3">
                        <label for="uploading_picture_{{$uuid}}" class="form-label">Picture</label>
                        <input name="uploading_picture_{{$uuid}}" type="file" class="form-control" id="uploading_picture_{{$uuid}}" accept="image/png, image/jpeg" required>
                        <input name="savedpicture" type="hidden" class="form-control" id="savedpicture_{{$uuid}}" value="" required>
                        <div class="box-2">
                            <div class="result_{{$uuid}}"></div>
                        </div>
                        <div class="box-2 img-result_{{$uuid}} hide">
                            <img class="cropped_{{$uuid}}" src="" alt="{{$alt}}" />
                        </div>
                        <div class="box">
                            <div class="options hide">
                                <label>Width</label>
                                <input type="number" class="img-w" value="300" min="100" max="1200" required />
                            </div>
                            <button class="btn save_{{$uuid}} hide">Save</button>
                        </div>
                        <button class="btn btn-outline-danger" type="submit">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- <script src='https://cdnjs.cloudflare.com/ajax/libs/cropperjs/0.8.1/cropper.min.js'></script> -->
<script>
    // vars
    let result_{{$uuid}} = document.querySelector('.result_{{$uuid}}'),
        img_result_{{$uuid}} = document.querySelector('.img-result_{{$uuid}}'),
        save_{{$uuid}} = document.querySelector('.save_{{$uuid}}'),
        cropped_{{$uuid}} = document.querySelector('.cropped_{{$uuid}}'),
        img_w_{{$uuid}} = document.querySelector('.img-w'),
        upload_{{$uuid}} = document.querySelector('#uploading_picture_{{$uuid}}'),
        cropper_{{$uuid}} = '';

    // on change show image with crop options
    upload_{{$uuid}}.addEventListener('change', e => {
        if (e.target.files.length) {
            // start file reader
            const reader = new FileReader();
            reader.onload = e => {
                if (e.target.result) {
                    // create new image
                    let img = document.createElement('img');
                    img.id = 'image';
                    img.src = e.target.result;
                    // clean result_{{$uuid}} before
                    result_{{$uuid}}.innerHTML = '';
                    // append new image
                    result_{{$uuid}}.appendChild(img);
                    // show save_{{$uuid}} btn and options
                    save_{{$uuid}}.classList.remove('hide');
                    // options.classList.remove('hide');
                    // init cropper
                    cropper_{{$uuid}} = new Cropper(img);
                }
            };
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    // save_{{$uuid}} on click
    save_{{$uuid}}.addEventListener('click', e => {
        e.preventDefault();
        // get result_{{$uuid}} to data uri
        let imgSrc = cropper_{{$uuid}}.getCroppedCanvas({
            width: img_w_{{$uuid}}.value // input value
        }).toDataURL();
        // remove hide class of img
        cropped_{{$uuid}}.classList.remove('hide');
        img_result_{{$uuid}}.classList.remove('hide');
        // show image cropped_{{$uuid}}
        cropped_{{$uuid}}.src = imgSrc;
        document.getElementById('savedpicture_{{$uuid}}').value = imgSrc;
    });

    document.querySelector('.form_{{$uuid}}').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        // console.log(formData.entries());
        // for (let [key, value] of formData.entries()) {
        //     console.log(key, value);
        // }
        formData.append('disk', '{{$disk}}');
        formData.append('path', '{{$path}}');
        formData.append('name', '{{$name}}');
        // console.log(formData);
        axios.post("{{ route('request.imageUpload') }}", formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function(response) {
                // handle success
                // alert('Image uploaded successfully!');
                // console.log(response);
                cropped_{{$uuid}}.classList.add('hide');
                save_{{$uuid}}.classList.add('hide');
                result_{{$uuid}}.innerHTML = '';
                upload_{{$uuid}}.value = '';
                document.getElementById('basicImg_{{$uuid}}').src = response.data.message + "?t=" + new Date().getTime();
            })
            .catch(function(error) {
                // handle error
                alert('Upload_{{$uuid}} failed!');
            });
    });
</script>