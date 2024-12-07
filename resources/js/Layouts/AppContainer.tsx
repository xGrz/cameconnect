import * as React from 'react';
import {PropsWithChildren} from 'react';
import Box from '@mui/material/Box';
import CssBaseline from '@mui/material/CssBaseline';
import Header from "@/Layouts/Header";
import Footer from "@/Layouts/Footer";


export default function AppContainer({children}: PropsWithChildren) {

    return (
        <Box sx={{display: "flex", flexDirection: "column", minHeight: "100vh"}}>
            <CssBaseline/>
            <Header/>

            <Box sx={{flexGrow: 1, marginTop: 2, marginBottom: 2}}>
                {children}
            </Box>
            <Footer/>
        </Box>
    );
}
