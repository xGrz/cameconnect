import React from "react";
import {Container} from "@mui/material";
import {AppProvider} from "@/Providers/AppProvider";
import {Deferred} from "@inertiajs/react";
import DashboardCommands from "@/Pages/DashboardCommands";
import Loading from "@/Components/Loading";

export default () => {

    return (
        <AppProvider>
            <Container>
                <div>CAME Connect Dashboard</div>
                <Deferred
                    data={"commands"}
                    fallback={<Loading/>}
                >
                    <DashboardCommands/>
                </Deferred>
            </Container>
        </AppProvider>
    );
}



