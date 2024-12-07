import {CssBaseline, ThemeProvider} from "@mui/material";
import React, {PropsWithChildren} from "react";
import AppContainer from "@/Layouts/AppContainer";
import theme from '@/Layouts/Theme/theme';


export function AppProvider({children}: PropsWithChildren) {

    return (
        <React.StrictMode>
            <ThemeProvider theme={theme}>
                <CssBaseline/>
                <AppContainer>
                    {children}
                </AppContainer>
            </ThemeProvider>
        </React.StrictMode>
    )
}
