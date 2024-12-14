import React from "react";
import {CircularProgress} from "@mui/material";
import Box from "@mui/material/Box";


interface ILoadingProps {
    spacing?: number;
}

export default ({spacing = 5}: ILoadingProps) => {
    return (
        <Box textAlign="center" sx={{ paddingY: spacing}}>
            <CircularProgress color="inherit"/>
        </Box>
    )
}
