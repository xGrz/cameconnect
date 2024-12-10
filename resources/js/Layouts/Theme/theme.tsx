import {createTheme} from "@mui/material";
import {blue} from "@mui/material/colors";

const theme = createTheme({
    palette: {
        text: {
            primary: 'rgba(255,255,255,.95)',
        },
        background: {
            default: blue[800]
        }
    }
})

export default theme;
