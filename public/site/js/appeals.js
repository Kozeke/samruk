$(document).ready(function () {

    if ($("#feedback").length) {
        console.log("Asd");
        var calc = new Vue({
            el: '#feedback',
            delimiters: ['@[[', ']]@'],
            data: {
                selected_code_id: "",
                lock_inputs: false,
                price: "",
                date_to_finish: "",
                date_to: "",
                reason: "",
                attachment_one: "",
                attachment_two: "",
                successMessage: false,
                appeal_title:"",
                appeal_text:"",
                base_pdf:"",
                cms_pdf:"",
            },
            methods: {
                lockInputs() {
                    this.lock_inputs = !this.lock_inputs
                    console.log(this.price)
                },
                async printPdf() {
                    var self = this;
                    await axios({
                        url: '/print-pdf',
                        method: 'POST',
                        responseType: 'blob',
                        data: {
                            _token: $('meta[name="_token"]').attr('content'),
                            date_to_finish: self.date_to_finish,
                            price: self.price,
                            selected_code_id: self.selected_code_id,
                            date_to: self.date_to,
                            reason: self.reason,
                            attachment_one: self.attachment_one,
                            attachment_two: self.attachment_two,
                            appeal_title: self.appeal_title,
                            appeal_text: self.appeal_text,
                        }
                    }).then((response) => {

                        const contentDisposition = response.headers['content-disposition'];
                        let fileName = 'unknown';
                        if (contentDisposition) {
                            const fileNameMatch = contentDisposition.match(/utf-8''(.+)/);
                            if (fileNameMatch.length === 2)
                                fileName = fileNameMatch[1];
                        }
                        console.log(response.data)
                        var pdf_blob = new Blob([response.data]);
                        const url = window.URL.createObjectURL(pdf_blob);
                        const link = document.createElement('a');
                        link.href = url;
                        link.setAttribute('download', decodeURI(fileName)+'.pdf');
                        document.body.appendChild(link);
                        self.convertPdfToBase64(response.data);

                        link.click();
                        console.log(url);
                    })
                },
                convertPdfToBase64(fileToLoad){
                    var self = this;
                    // FileReader function for read the file.
                    var fileReader = new FileReader();
                    var base64;
                    fileReader.onload = function(fileLoadedEvent) {
                        base64 = fileLoadedEvent.target.result;
                        self.base_pdf = base64.replace('data:', '')
                            .replace(/^.+,/, '');
                        // this.pdfBase64 = base64;
                        // console.log(this.pdfBase64);
                    };
                    // Convert data to base64
                    fileReader.readAsDataURL(fileToLoad);
                },
                async sendAppealTemplate(){
                    var self = this;
                    await axios({
                        url: '/send-appeal-template',
                        method: 'POST',
                        data: {
                            _token: $('meta[name="_token"]').attr('content'),
                            date_to_finish: self.date_to_finish,
                            price: self.price,
                            selected_code_id: self.selected_code_id,
                            date_to: self.date_to,
                            reason: self.reason,
                            attachment_one: self.attachment_one,
                            attachment_two: self.attachment_two,
                        }
                    }).then((response) => {
                        console.log("success", response)
                        self.successMessage = true;
                    })
                },
                async signDocument(){
                    var self = this;
                    await axios({
                        url: '/sign-document',
                        method: 'POST',
                        data: {
                            _token: $('meta[name="_token"]').attr('content'),
                            cms_pdf: self.cms_pdf,
                        }
                    }).then((response) => {
                        console.log("success", response)
                        self.successMessage = true;
                    })
                }
            },
            watch: {
                selected_code_id() {
                    this.lock_inputs = false;
                    this.price = "";
                    this.date_to_finish = "";
                    this.reason = "";
                    console.log("changed", this.selected_code_id)
                }
            }
        });
    }

})
