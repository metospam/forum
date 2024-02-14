import axios from "axios";

class TopicService {
    API_URL = 'http://0.0.0.0/api/v1/topics';

    async getTopics(offset = null, limit = null) {
        return await axios.post(this.API_URL, {
            limit: limit,
            offset: offset
        });
    }

}

export default new TopicService();