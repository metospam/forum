import axios from "axios";
import OptionsService from "./OptionsService";

class PostService {
    API_URL = 'http://0.0.0.0/api/v1/posts';

    async getPosts(page = 1, per_page = 10) {
        return await axios.post(this.API_URL, {
            page: page,
            per_page: per_page
        });
    }

    async createPost(title, content, image) {
        const headers = OptionsService.getHeaders();

        return await axios.post(this.API_URL + '/create', {
            title: title,
            content: content,
            image: image,
        }, {headers});
    }

    async getPost(slug) {
        return await axios.get(this.API_URL + `/${slug}`);
    }

    async likePost(slug){
        const headers = OptionsService.getHeaders();
        return await axios.post(this.API_URL + `/like/${slug}`, {}, {headers});
    }

    async dislikePost(slug){
        const headers = OptionsService.getHeaders();
        return await axios.post(this.API_URL + `/dislike/${slug}`, {}, {headers});
    }

}

export default new PostService();
