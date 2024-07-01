<div class="sec-content">
            <div class="layout">
                <h1 class="event-title" style="  padding-bottom: 0px;margin-bottom: 0px;padding-top: 10px">Phân loại và giải đáp</h1>
                <div class="layout-cam">
                    <div class="webcam">
                        <div class="content-webcam">
                        <div id="webcam-container"></div>
                        <div id="label-container"></div>
                        </div>
                        <div class="submit-button">
                            <button type="button" id="toggle-button" class="styled-button" onclick="toggleWebcam()">Camera</button>
                        </div>
                    </div>
                    <div class="chat">
                        <iframe
                        allow="microphone;"
                        width="350"
                        height="485"
                        src="https://console.dialogflow.com/api-client/demo/embedded/341fffd1-d943-49ee-b078-bb761fd62476">
                    </iframe>
                    </div>
                </div>
                <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@latest/dist/tf.min.js"></script>
                <script
                    src="https://cdn.jsdelivr.net/npm/@teachablemachine/image@latest/dist/teachablemachine-image.min.js"></script>
                <script type="text/javascript">
                    let toggleButton = document.getElementById("toggle-button");
                    let webcamContainer = document.getElementById("webcam-container");
                    const URL = "https://teachablemachine.withgoogle.com/models/ItqyBadyl/";

                    let model, webcam, labelContainer, maxPredictions;
                    let webcamInitialized = false;
                    let webcamStopped = true;

                    async function toggleWebcam() {
                        if (webcamStopped) {
                            await startWebcam();
                            toggleButton.innerText = "Dừng";
                        } else {
                            stopWebcam();
                            toggleButton.innerText = "Camera";
                        }
                    }

                    async function startWebcam() {
                        const modelURL = URL + "model.json";
                        const metadataURL = URL + "metadata.json";

                        model = await tmImage.load(modelURL, metadataURL);
                        maxPredictions = model.getTotalClasses();

                        const flip = true;
                        webcam = new tmImage.Webcam(765, 400, flip);
                        await webcam.setup();
                        await webcam.play();
                        window.requestAnimationFrame(loop);

                        document.getElementById("webcam-container").appendChild(webcam.canvas);
                        labelContainer = document.createElement("div");
                        labelContainer.id = "label-container";
                        webcamContainer.appendChild(labelContainer);
                        webcamContainer.style.display = "block";
                        toggleButton.style.display = "block";
                        webcamInitialized = true;
                        webcamStopped = false;
                        console.log("Webcam initialized.");
                    }

                    function stopWebcam() {
                        if (webcamInitialized && !webcamStopped) {
                            webcam.stop();
                            webcam.canvas.remove();
                            labelContainer.remove();
                            webcamStopped = true;
                            console.log("Webcam stopped.");
                        }
                    }

                    async function loop() {
                        if (!webcamStopped) {
                            webcam.update(); 
                            await predict(); 
                            window.requestAnimationFrame(loop); 
                        }
                    }

                    async function predict() {
                        const predictions = await model.predictTopK(webcam.canvas);
                        labelContainer.innerText = predictions[0].className;

                    }
                </script>
            </div>
           
</div>
</div>