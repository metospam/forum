import axios from "axios";
import OptionsService from "./OptionsService";

class AuthService{

    API_URL = 'http://0.0.0.0/api/v1/auth';

    async login(email, password) {
        return await axios.post(this.API_URL + '/login', {
            email: email,
            password: password
        });
    }

    async register(username, email, password, password_confirmation){
        return await axios.post(this.API_URL + '/register', {
            username: username,
            email: email,
            password: password,
            password_confirmation: password_confirmation,
        });
    }

    async refreshToken(){
        const headers = OptionsService.getHeaders();

        return await axios.post(this.API_URL + '/refresh', {}, {headers});
    }

    async getUserData(){
        const headers = OptionsService.getHeaders();
        return await axios.post(this.API_URL + '/data', {}, {headers});
    }
}

export default new AuthService();
