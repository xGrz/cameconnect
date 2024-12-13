import {AppProvider} from "@/Providers/AppProvider";
import {Container} from "@mui/material";
import SiteListItem from "@/Components/Connect/SiteListItem";
import React from "react";
import {ISiteTree} from "@/types/inertia";


interface SitesTreeViewProps {
    siteList: ISiteTree[];
}

export default function SitesTreeView({siteList}: SitesTreeViewProps) {
    return (
        <AppProvider>
            <Container>
                {siteList.map(site => (
                    <SiteListItem key={site.id} site={site}/>
                ))}
            </Container>
        </AppProvider>
    )
}
