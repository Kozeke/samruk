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
        appeal_title: "",
        appeal_text: "",
        base_pdf: "",
        cms_pdf: "",
        appeal_signature_id: "",
        signed: false,
        value_qr: "",
        signerFIO: "",
        errors: "",
    },
    methods: {
        setCMSPDF(cms_pdf) {
            this.cms_pdf = cms_pdf;
        },
        getBasePdfValue() {
            console.log(this.base_pdf)
            return this.base_pdf;
        },
        lockInputs() {
            this.lock_inputs = !this.lock_inputs
            console.log(this.price)
        },
        async printPdf(getBase64 = false) {
            console.log(getBase64);
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
                    signed: self.signed,
                    base_pdf: self.base_pdf,
                    cms_pdf: self.cms_pdf,
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
                if (!getBase64) {
                    console.log("Asd");
                    var pdf_blob = new Blob([response.data]);
                    const url = window.URL.createObjectURL(pdf_blob);
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', decodeURI(fileName) + '.pdf');
                    document.body.appendChild(link);
                    link.click();
                    console.log(url);
                } else {
                    self.convertPdfToBase64(response.data);
                    self.reInitVars()
                }
            })
        },
        reInitVars() {
            this.lock_inputs = false;
            this.price = "";
            this.date_to_finish = "";
            this.reason = "";
            this.signed = "";
            this.base_pdf = "";
            this.cms_pdf = "";
        },
        convertPdfToBase64(fileToLoad) {
            var self = this;
            // FileReader function for read the file.
            var fileReader = new FileReader();
            var base64;
            fileReader.onload = function (fileLoadedEvent) {
                base64 = fileLoadedEvent.target.result;
                self.base_pdf = base64.replace('data:', '')
                    .replace(/^.+,/, '');
                // this.pdfBase64 = base64;
                // console.log(self.base_pdf);
            };
            // Convert data to base64
            fileReader.readAsDataURL(fileToLoad);
        },
        async sendAppealTemplate() {
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
                    signed: self.signed,
                    base_pdf: self.base_pdf,
                    cms_pdf: self.cms_pdf,
                }
            }).then((response) => {
                console.log("success", response)
                self.successMessage = true;
                self.errors = [];
            }).catch((response) => {
                self.successMessage = false;
                console.log("error", response)
                self.errors = response.response.data.errors
                console.log(self.errors);
            })
        },
        async signDocument() {
            var self = this;
            await axios({
                url: '/sign-document',
                method: 'POST',
                data: {
                    _token: $('meta[name="_token"]').attr('content'),
                    cms_pdf: self.cms_pdf,
                    base_pdf: self.base_pdf,
                }
            }).then((response) => {
                console.log("success", response)
                self.signed = true;
                self.signerFIO = response.data['fio']
                // self.value_qr = response.data.value_qr
                // console.log(self.value_qr)
            })
        },

    },
    watch: {
        async date_to_finish() {
            if (this.cms_pdf) {
                alert("При изменении документа, нужно будет вновь подписать")
            }
            await this.printPdf(true)
        },
        async price() {
            if (this.cms_pdf) {
                alert("При изменении документа, нужно будет вновь подписать")
            }
            await this.printPdf(true)
        },
        async date_to() {
            if (this.cms_pdf) {
                alert("При изменении документа, нужно будет вновь подписать")
            }
            await this.printPdf(true)
        },
        async reason() {
            if (this.cms_pdf) {
                alert("При изменении документа, нужно будет вновь подписать")
            }
            await this.printPdf(true)
        },
        async attachment_one() {
            if (this.cms_pdf) {
                alert("При изменении документа, нужно будет вновь подписать")
            }
            await this.printPdf(true)
        },
        async attachment_two() {
            if (this.cms_pdf) {
                alert("При изменении документа, нужно будет вновь подписать")
            }
            await this.printPdf(true)
        },
    },

});

