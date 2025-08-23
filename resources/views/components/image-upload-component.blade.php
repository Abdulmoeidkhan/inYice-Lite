<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/cropper/2.3.4/cropper.min.css'>
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
    <div class="col-lg-4 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <div class="mb-4">
                    <h5 class="card-title fw-semibold">{{$alt}}</h5>
                </div>
                @if(Storage::disk($disk)->exists($path.$name.'.png'))
                <img id="basicImg" src="{{Storage::disk($disk)->url($path.$name.'.png')}}" width="200px" height="200px" class="rounded mx-auto d-block" alt="{{$alt}}">
                @else
                <img id="basicImg" src="{{asset('assets/images/profile/user-1.jpg')}}" width="200px" height="200px" class="rounded mx-auto d-block" alt="{{$alt}}">
                @endIf
                <br />
                <form action="{{route('request.imageUpload')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="input-group">
                        <input type="hidden" value="{{$name}}" name="id" required />
                    </div>
                    <div class="mb-3">
                        <label for="uploading_picture" class="form-label">Picture</label>
                        <input name="uploading_picture" type="file" class="form-control" id="uploading_picture" accept="image/png, image/jpeg" required>
                        <input name="savedpicture" type="hidden" class="form-control" id="savedpicture" value="" required>
                        <div class="box-2">
                            <div class="result"></div>
                        </div>
                        <div class="box-2 img-result hide">
                            <img class="cropped" src="" alt="{{$alt}}" />
                        </div>
                        <div class="box">
                            <div class="options hide">
                                <label>Width</label>
                                <input type="number" class="img-w" value="300" min="100" max="1200" required />
                            </div>
                            <button class="btn save hide">Save</button>
                        </div>
                        <button class="btn btn-outline-danger" type="submit">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src='https://cdnjs.cloudflare.com/ajax/libs/cropperjs/0.8.1/cropper.min.js'></script>
<script>
    // vars
    let result = document.querySelector('.result'),
        img_result = document.querySelector('.img-result'),
        save = document.querySelector('.save'),
        cropped = document.querySelector('.cropped'),
        img_w = document.querySelector('.img-w'),
        upload = document.querySelector('#uploading_picture'),
        cropper = '';

    // on change show image with crop options
    upload.addEventListener('change', e => {
        if (e.target.files.length) {
            // start file reader
            const reader = new FileReader();
            reader.onload = e => {
                if (e.target.result) {
                    // create new image
                    let img = document.createElement('img');
                    img.id = 'image';
                    img.src = e.target.result;
                    // clean result before
                    result.innerHTML = '';
                    // append new image
                    result.appendChild(img);
                    // show save btn and options
                    save.classList.remove('hide');
                    // options.classList.remove('hide');
                    // init cropper
                    cropper = new Cropper(img);
                }
            };
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    // save on click
    save.addEventListener('click', e => {
        e.preventDefault();
        // get result to data uri
        let imgSrc = cropper.getCroppedCanvas({
            width: img_w.value // input value
        }).toDataURL();
        // remove hide class of img
        cropped.classList.remove('hide');
        img_result.classList.remove('hide');
        // show image cropped
        cropped.src = imgSrc;
        document.getElementById('savedpicture').value = imgSrc;
    });

    document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        // console.log(formData.entries());
        // for (let [key, value] of formData.entries()) {
        //     console.log(key, value);
        // }
        formData.append('disk', '{{$disk}}');
        formData.append('path', '{{$path}}');
        formData.append('name', '{{$name}}');

        axios.post("{{ route('request.imageUpload') }}", formData, {
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function(response) {
                // handle success
                // alert('Image uploaded successfully!');
                console.log(response);
                cropped.classList.add('hide');
                save.classList.add('hide');
                result.innerHTML = '';
                upload.value = '';
                document.getElementById('basicImg').src = response.data.message + "?t=" + new Date().getTime();
            })
            .catch(function(error) {
                // handle error
                alert('Upload failed!');
            });
    });
</script>