import OptionsService from "./OptionsService";
import axios from "axios";

class UserService {

    API_URL = 'http://0.0.0.0/api/v1/users'

    async getUserWithPosts(username, page = 1, per_page = 10) {
        return await axios.post(this.API_URL + `/${username}`, {
            page: page,
            per_page: per_page
        })
    }

    async updateUser(username) {
        const headers = OptionsService.getHeaders();
        return await axios.patch(this.API_URL, {username: username}, {headers})
    }

    async uploadAvatarToUser(image) {
        const access_token = localStorage.getItem('access_token');
        const headers = {
            'Content-Type': "multipart/form-data",
            "Authorization": `Bearer ${access_token}`,
        }

        return await axios.post(this.API_URL + '/avatar', {image: image}, {headers})
    }

}

export default new UserService();
