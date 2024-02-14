class OptionsService {

    getHeaders(){
        const access_token = localStorage.getItem('access_token');
        return {
            "Authorization": `Bearer ${access_token}`
        }
    }

}

export default new OptionsService();