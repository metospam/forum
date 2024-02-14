import axios from "axios";
import OptionsService from "./OptionsService";

class CommentService {

    API_URL = 'http://0.0.0.0/api/v1/comments';

    async createComment(content, postId, commentId = null){
        const headers = OptionsService.getHeaders();

        return await axios.post(this.API_URL + '/create', {
            post_id: postId,
            content: content,
            comment_id: commentId,
        }, {headers})
    }

}

export default new CommentService();
