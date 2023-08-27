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
                attachment_two: ""
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
                        }
                    }).then((response) => {
                        const contentDisposition = response.headers['content-disposition'];
                        let fileName = 'unknown';
                        if (contentDisposition) {
                            const fileNameMatch = contentDisposition.match(/utf-8''(.+)/);
                            if (fileNameMatch.length === 2)
                                fileName = fileNameMatch[1];
                        }
                        const url = window.URL.createObjectURL(new Blob([response.data]));
                        const link = document.createElement('a');
                        link.href = url;
                        link.setAttribute('download', decodeURI(fileName)+'.pdf');
                        document.body.appendChild(link);
                        link.click();
                    })
                },
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
