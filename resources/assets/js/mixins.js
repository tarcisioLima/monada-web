module.exports = {
    data () {
        return  {
            basepath: this.getBasePath()
        }
    },
    methods: {
        getBasePath () {
            let url = window.location.href;
            let arr = url.split("/");
            return arr[0] + "//" + arr[2] + '/api/v1'
        }
    }
}