export default {
    data: function () {
        return {
            isLoading: false,
            winH: window.height
        }
    },
    created(){

    },
    beforeCreate() {
 
    },
    methods: {
        request (url, params, cb, method = 'GET', options = ''){
            var that = this;
            if(!that.isLoading){
                that.isLoading = true;

                if(method === 'GET'){
                    if(params){
                        var esc = encodeURIComponent;
                        url += '?' + Object.keys(params)
                            .map(k => esc(k) + '=' + esc(params[k]))
                            .join('&');
                    }

                    axios
                        .get(url)
                        .then(response => {
                            that.isLoading = false
                            if(response.data && response.data.message){
                                if(response.data.success) {
                                    that.$message.success(response.data.message);
                                }else{
                                    that.$message.error(response.data.message);
                                }
                            }
                            if(typeof cb === 'function'){
                                cb(response.data)
                            }
                        });
                }else{
                    axios
                        .post(url, params, options)
                        .then(response => {
                            that.isLoading = false
                            if(response.data && response.data.message){
                                if(response.data.success) {
                                    that.$message.success(response.data.message);
                                }else{
                                    that.$message.error(response.data.message);
                                }
                            }
                            if(typeof cb === 'function'){
                                cb(response.data)
                            }
                        });
                }
            }
        },
        number_format(str){
            return str.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        },
		copy(id){
            var node = document.getElementById( id );
            if ( document.selection ) {
                var range = document.body.createTextRange();
                range.moveToElementText( node  );
                range.select();
            } else if ( window.getSelection ) {
                var range = document.createRange();
                range.selectNodeContents( node );
                window.getSelection().removeAllRanges();
                window.getSelection().addRange( range );
            }
            document.execCommand("copy");
            this.$message.success('Copied', 1);
        },
        download(filename, text, cb) {
            var element = document.createElement('a');
            element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
            element.setAttribute('download', filename);

            element.style.display = 'none';
            document.body.appendChild(element);

            element.click();

            document.body.removeChild(element);

            if(typeof cb === 'function'){
                cb();
            }
        },
        validate(fields, params, cb){
            let invalids = [];
            for(let x in params){
                if(typeof params[x] === 'object'){
                    for(let i in params[x]){
                        if(fields.indexOf(i) !== -1 && !params[x][i]){
                            invalids.push(i);
                        }
                    }
                }else{
                    if(fields.indexOf(x) !== -1 && !params[x]){
                        invalids.push(x);
                    }
                }
            }
            if(typeof cb === 'function'){
                cb(invalids);
            }
        },
        get_object_val(k, obj){
            let item = obj.filter(function(e) { return e.ID === k; });
            if(item.length)
                return item[0].NAME;
            return '';
        }
    },
}