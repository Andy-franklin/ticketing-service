<template>
    <div class="container">
        <div class="row">
            <div class="col">
                <h2 class="text-center mt-4">Ticket Check In</h2>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p class="error">{{ error }}</p>
                <p class="decode-result text-center">Status: <b>{{ status }}</b></p>
                <div class="qr-stream-wrapper" v-if="ticketFound === false">
                    <qrcode-stream @decode="onDecode"></qrcode-stream>
                </div>
                <div v-else>
                    <p>UserID: {{ ticketInformation.user_id }}</p>
                    <p>Ticket Type: {{ ticketInformation.ticket_type }}</p>
                    <p>Ticket Created: {{ ticketInformation.createdAt }}</p>

                    <a class="btn btn-outline-danger" @click="reset()">Restart</a>
                    <a class="btn btn-primary" @click="checkIn()">Check In</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { QrcodeStream } from 'vue-qrcode-reader'
    const axios = require('axios');


    export default {
        name: "App",
        components: {
            QrcodeStream,
        },
        data () {
            return {
                result: '',
                status: 'Ready to scan',
                error: '',
                requesting: false,
                ticketFound: false,
                ticketInformation: {}
            }
        },
        methods: {
            checkIn() {

            },
            reset() {
                this.ticketInformation = false;
                this.ticketFound = false;
                this.requesting = false;
                this.result = '';
                this.status = 'Ready to scan';
            },
            getData(ticketGuid) {
                this.status = 'QR code read';
                if (!this.requsting) {
                    this.status = 'Requesting ticket information';
                    this.requsting = true;
                    axios.get('/api/tickets/' + ticketGuid)
                        .then((response) => {
                            this.status = 'Ticket successfully found';
                            this.ticketFound = true;
                            this.requsting = false;
                            console.log(response.data);

                            this.ticketInformation = response.data;
                            console.log(this.ticketInformation)
                        })
                        .catch((error) => {
                            this.status = 'Something went wrong';
                            this.requsting = false;
                            console.log(error);
                        })
                }
            },
            onDecode(result) {
                this.result = result;

                let ticketParts = result.split("--");

                if (ticketParts[0] !== 'ticket') {
                    this.status = 'Invalid QR Code'
                } else {
                    this.getData(ticketParts[1])
                }
            },
            async onInit(promise) {
                try {
                    await promise
                } catch (error) {
                    if (error.name === 'NotAllowedError') {
                        this.error = "ERROR: you need to grant camera access permission"
                    } else if (error.name === 'NotFoundError') {
                        this.error = "ERROR: no camera on this device"
                    } else if (error.name === 'NotSupportedError') {
                        this.error = "ERROR: secure context required (HTTPS, localhost)"
                    } else if (error.name === 'NotReadableError') {
                        this.error = "ERROR: is the camera already in use?"
                    } else if (error.name === 'OverconstrainedError') {
                        this.error = "ERROR: installed cameras are not suitable"
                    } else if (error.name === 'StreamApiNotSupportedError') {
                        this.error = "ERROR: Stream API is not supported in this browser"
                    }
                }
            }
        }
    }
</script>

<style scoped lang="scss">
    .error {
        font-weight: bold;
        color: red;
    }

    .qr-stream-wrapper {
        height: 300px;
    }
</style>
