<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Scan QR') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div x-data="qrScanner()" x-init="startScanner()" class="mt-6">
                    <div id="qr-reader" class="w-full"></div>
                    <div x-show="scannedData" class="p-4 mt-4 text-green-800 bg-green-100 rounded">
                        <p>Scanned Data:</p>
                        <p x-text="scannedData"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function qrScanner() {
            return {
                scanner: null,
                scannedData: '',
                startScanner() {
                    this.scanner = new Html5Qrcode("qr-reader");
                    this.scanner.start(
                        { facingMode: "environment" }, // Request for the environment-facing camera
                        {
                            fps: 10,
                            qrbox: function(viewfinderWidth, viewfinderHeight) {
                                // Adjust qrbox size for mobile
                                const minEdgePercentage = 0.7; // 70% of the viewfinder's min edge
                                const minEdgeSize = Math.min(viewfinderWidth, viewfinderHeight);
                                return {
                                    width: minEdgeSize * minEdgePercentage,
                                    height: minEdgeSize * minEdgePercentage
                                };
                            }
                        },
                        (decodedText, decodedResult) => {
                            this.handleScannedData(decodedText);
                        },
                        (errorMessage) => {
                            console.error(errorMessage);
                        }
                    ).catch(err => {
                        console.error(err);
                        alert('Unable to access the camera. Please check the permissions.');
                    });
                },
                stopScanner() {
                    if (this.scanner) {
                        this.scanner.stop().then(() => {
                            console.log('QR Code scanning stopped.');
                        }).catch(err => {
                            console.error('Error stopping the scanner', err);
                        });
                    }
                },
                handleScannedData(decodedText) {
                    this.scannedData = decodedText;
                    const url = new URL(decodedText);
                    console.log(url)
                    const routeName = '/attendances/mark/*/*/*';

                    const routeRegex = new RegExp(routeName .replace(/\*/g, '[^/]+'));

                    if (routeRegex.test(url.pathname)) {
                        // Perform the GET request to the route
                        fetch(decodedText)
                            .then(response => response.json())
                            .then(data => {
                                console.log('Attendance recorded:', data);
                                alert('Attendance recorded successfully!');
                                this.stopScanner(); // Optionally stop the scanner
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Failed to record attendance.');
                            });
                    } else {
                        alert('Invalid QR Code. Please scan a valid attendance QR code.');
                    }
                }
            }
        }

        // Ensure the script runs when the page is loaded
        document.addEventListener('DOMContentLoaded', function() {
            Alpine.data('qrScanner').startScanner();
        });
    </script>
</x-app-layout>
