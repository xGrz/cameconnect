import Toolbar from "@mui/material/Toolbar";

import * as React from "react";
import Box from "@mui/material/Box";
import {blue} from "@mui/material/colors";
import LogoutButton from "@/Components/Auth/LogoutButton";
import SettingsButton from "@/Components/SettingsButton";

import AppLogo from "@/Components/AppLogo";


export default function Header() {

    return (
        <Box sx={{backgroundColor: blue[600], color: 'white'}}>
            <Toolbar>
                <AppLogo />
                <SettingsButton/>
                <LogoutButton/>
            </Toolbar>
        </Box>
    );

}
