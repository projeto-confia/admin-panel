import { precisionNews } from "./pages/precisionNews";
import { newsChart } from "./pages/newsChart";
import { welcome } from "./pages/welcome";
import { userCreate } from "./pages/user/create"
import { userEdit } from "./pages/user/edit"
import curate from './pages/curatorship/curate'

const CONFIA = {
    pages: {
        precisionNews,
        newsChart,
        welcome,
        user: {
            create: userCreate,
            edit: userEdit,
        },
        curatorship: { curate },
    }
};

export default CONFIA;
