import { precisionNews } from "./pages/precisionNews";
import { newsChart } from "./pages/newsChart";
import { welcome } from "./pages/welcome";
import { userCreate } from "./pages/user/create"
import { userEdit } from "./pages/user/edit"
import curate from './pages/curatorship/curate'
import { create as createConfiguration } from "./pages/configuration/create"
import { edit as editConfiguration } from "./pages/configuration/edit"

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
        configuration: { create: createConfiguration, edit: editConfiguration },
    }
};

export default CONFIA;
