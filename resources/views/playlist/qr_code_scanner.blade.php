
<div class="row ">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">

            </div>

            <div class="card-body text-center">

                <section class="container" id="cam-content">
                    <div class="mb-3">
                        <button class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2" id="startButton"  onclick="load_cam()">Start</button>
                        <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none" id="resetButton">Stop</button>
                    </div>

                    <div class="flex justify-center">
                        <video id="video" width="300" height="200" style="border: 1px solid gray"></video>
                    </div>

                    <div id="sourceSelectPanel" style="display:none">
                        <span for="sourceSelect">Change video source:</span>
                        <select id="sourceSelect" style="max-width:400px">
                        </select>
                    </div>

                    <div @if($type != 'send_to_delivery') style="display:none" @endif>
                        <select
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                            dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            name="delivery_man_id" id="delivery_man_id">
                            <option value="0">{{__('Select Delivery Man ...')}}</option>
                            @foreach(\App\Models\User::where('user_type','delivery_man')->get() as $user)
                                    <option value="{{$user->id}}">{{$user->email}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div style="display: none" class="text-center">
                        <span for="decoding-style"> Decoding Style:</span>
                        <select id="decoding-style" size="1">
                            <option value="once">Decode once</option>
                            <option value="continuously">Decode continuously</option>
                        </select>
                    </div>

                    <span>Result:</span>
                    <pre><code id="result"></code></pre>
                </section>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="text-center" id="order_scanned">
            <h3>Scann Results</h3>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://unpkg.com/@zxing/library@latest/umd/index.min.js"></script>
<script type="text/javascript">

    function decodeOnce(codeReader, selectedDeviceId) {
        codeReader.decodeFromInputVideoDevice(selectedDeviceId, 'video').then((result) => {
            console.log(result.text)
            @if($type == 'send_to_delivery')
                if($('#delivery_man_id').val() == 0){
                    alert('برجاء اختيار المندوب');
                    const myTimeout = setTimeout(load_cam, 5000);
                    return 0;
                }
            @endif

                $.post('{{ route('admin.playlist.qr_output') }}', {
                    _token: '{{ csrf_token() }}',
                    code: result.text,
                    type: '{{$type}}',
                    delivery_man_id : $('#delivery_man_id').val()
                }, function(data) {
                    console.log(data);

                    $('#order_scanned').append(data.message);
                    const myTimeout = setTimeout(load_cam, 5000);
                    if (data.status == 1) {
                        showFrontendAlert('success','تم الأرسال');
                    } else {
                        showFrontendAlert('error','لم يتم الأرسال');
                    }
                });
        }).catch((err) => {
            console.error(err)
            document.getElementById('result').textContent = err
            const myTimeout = setTimeout(load_cam, 5000);
        })
    }


    function load_cam() {

        let selectedDeviceId;
        const codeReader = new ZXing.BrowserQRCodeReader();
        console.log('ZXing code reader initialized');

        const decodingStyle = document.getElementById('decoding-style').value;

        decodeOnce(codeReader, selectedDeviceId);

        console.log(`Started decode from camera with id ${selectedDeviceId}`)

        codeReader.getVideoInputDevices()
            .then((videoInputDevices) => {

                const sourceSelect = document.getElementById('sourceSelect')
                selectedDeviceId = videoInputDevices[0].deviceId

                if (videoInputDevices.length >= 1) {
                    videoInputDevices.forEach((element) => {
                        const sourceOption = document.createElement('option')
                        sourceOption.text = element.label
                        sourceOption.value = element.deviceId
                        sourceSelect.appendChild(sourceOption)
                    })

                    sourceSelect.onchange = () => {
                        selectedDeviceId = sourceSelect.value;
                    };

                    const sourceSelectPanel = document.getElementById('sourceSelectPanel')
                    sourceSelectPanel.style.display = 'block'
                }

                document.getElementById('startButton').addEventListener('click', () => {
                    const decodingStyle = document.getElementById('decoding-style').value;

                    decodeOnce(codeReader, selectedDeviceId);

                    console.log(`Started decode from camera with id ${selectedDeviceId}`)
                })

                document.getElementById('resetButton').addEventListener('click', () => {
                    codeReader.reset()
                    document.getElementById('result').textContent = '';
                    console.log('Reset.')
                })

            })

            .catch((err) => {
                console.error(err)
            })

    }
</script>
