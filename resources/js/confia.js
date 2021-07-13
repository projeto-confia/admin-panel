import { precisionNews } from "./pages/precisionNews";
import { newsChart } from "./pages/newsChart";
import { welcome } from "./pages/welcome";
import { userCreate } from "./pages/user/create"
const CONFIA = {
    pages: {
        precisionNews,
        newsChart,
        welcome,
        user: {
            create: userCreate,
        },
    }
};

export default CONFIA;
