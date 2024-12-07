import Toolbar from "@mui/material/Toolbar";
import Typography from "@mui/material/Typography";
import * as React from "react";
import Box from "@mui/material/Box";
import {blue} from "@mui/material/colors";


export default function Header() {
    return (
        <Box sx={{backgroundColor: blue[600], color: 'white'}}>
            <Toolbar>
                <Typography variant="h6" noWrap component="div">
                    <strong>CAME</strong> Connect
                </Typography>
            </Toolbar>
        </Box>
    );

}
