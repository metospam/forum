import axios from "axios";
import OptionsService from "./OptionsService";

class CommunityService {
    API_URL = 'http://0.0.0.0/api/v1/communities';

    async getPopularCommunities(limit = null) {
        return await axios.post(this.API_URL + '/popular', {
            limit: limit,
        });
    }

    async createCommunity(name) {
        const headers = OptionsService.getHeaders();

        return await axios.post(this.API_URL + '/create', {
            name: name,
        }, {headers});
    }

    async joinTheCommunity(id){
        const headers = OptionsService.getHeaders();
        return await axios.post(this.API_URL + `/join/${id}`, {}, {headers});
    }

    async leaveTheCommunity(id){
        const headers = OptionsService.getHeaders();
        return await axios.post(this.API_URL + `/leave/${id}`, {}, {headers});
    }

    async getCommunityWithPosts(slug, page = 1, per_page = 10){
        return await axios.post(this.API_URL + `/${slug}`, {
           page: page,
           per_page: per_page,
        });
    }

    async uploadAvatarToCommunity(slug, image){
        const access_token = localStorage.getItem('access_token');
        const headers = {
            'Content-Type': "multipart/form-data",
            "Authorization": `Bearer ${access_token}`,
        }

        return await axios.post(this.API_URL + `/avatar/${slug}`, {
            image: image,
        }, {headers});
    }

    async updateCommunity(slug, description){
        const headers = OptionsService.getHeaders();
        return await axios.patch(this.API_URL + `/update/${slug}`, {
            description: description,
        }, {headers});
    }

    async getCommunity(slug){
        return await axios.get(this.API_URL + `/${slug}`);
    }
}

export default new CommunityService();
