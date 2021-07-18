import { precisionNews } from "./pages/precisionNews";
import { newsChart } from "./pages/newsChart";
import { welcome } from "./pages/welcome";
import { userCreate } from "./pages/user/create"
import { userEdit } from "./pages/user/edit"
const CONFIA = {
    pages: {
        precisionNews,
        newsChart,
        welcome,
        user: {
            create: userCreate,
            edit: userEdit,
        },
    }
};

export default CONFIA;
