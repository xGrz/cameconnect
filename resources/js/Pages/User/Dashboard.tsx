import React from "react";
import {Container} from "@mui/material";
import {AppProvider} from "@/Providers/AppProvider";
import {IHomeResponse} from "@/types/inertia";
import SiteListItem from "@/Components/Connect/SiteListItem";

export default function Dashboard({siteList}: IHomeResponse) {


    return (
        <AppProvider>
            <Container>
                {siteList.map(site => (
                    <SiteListItem key={site.id} site={site}/>
                ))}
            </Container>
        </AppProvider>
    );
}
