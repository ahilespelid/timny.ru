export default  {
    methods: {
        getDate(date){
            if(!date) return '';
            date = new Date(date);

            var options = {
                year: 'numeric',
                month: 'numeric',
                day: 'numeric',
            };

            return date.toLocaleString("ru", options);
        },
        getTime(time){
            time = new Date(time);

            var options = {
                hour: 'numeric',
                minute: 'numeric',
            };

            return time.toLocaleString("ru", options);
        }
    }


}

