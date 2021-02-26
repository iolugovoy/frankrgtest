export default {
    methods: {
        isFile(item){
            return item.includes('.');
        },
        request(url,method,data){
            return new Promise((resolve, reject) => {
                let xhr = new XMLHttpRequest();
                xhr.open(method, url);
                // let formData = new FormData;
                // formData.append('action', 'upload',);
                // console.log(this.currentPath);
                // formData.append('current', this.currentPath);
                // formData.append("file", files[0]);


                xhr.send(data);

                xhr.onload = () => {
                    let json = JSON.parse(xhr.response);
                    if (json.isSuccess) {
                        resolve(json.data);
                    } else {
                        reject(json.data);
                    }

                }
                xhr.onerror = () => {
                    reject('Ошибка соединения');
                };
            })
        }
    }
}