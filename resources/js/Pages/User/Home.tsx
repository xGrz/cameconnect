import React from "react";
import {Container, List} from "@mui/material";
import {AppProvider} from "@/Providers/AppProvider";
import {IHomeResponse} from "@/types/inertia";
import SiteListItem from "@/Components/Connect/SiteListItem";

export default function Home({siteList}: IHomeResponse) {

    return (
        <AppProvider>
            <Container>
                <List sx={{backgroundColor: 'white'}}>
                    {siteList.map(site => (
                        <SiteListItem key={site.id} site={site}/>
                    ))}
                </List>
            </Container>
        </AppProvider>
    );
}
