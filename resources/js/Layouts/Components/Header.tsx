import Toolbar from "@mui/material/Toolbar";
import * as React from "react";
import Box from "@mui/material/Box";
import AppLogo from "@/Components/AppLogo";
import {useTheme} from "@mui/material";


export default function Header() {
    const theme = useTheme()

    return (
        <Box sx={{backgroundColor: theme.palette.background.default, color: 'white'}}>
            <Toolbar>
                {/*<SitesTreeButton />*/}
                <AppLogo/>
                {/*<SettingsButton/>*/}
                {/*<LogoutButton/>*/}
            </Toolbar>
        </Box>
    );

}
