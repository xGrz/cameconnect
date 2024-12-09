import React, {useEffect, useState} from "react";
import {Container, List, ListItem} from "@mui/material";
import {AppProvider} from "@/Providers/AppProvider";
import {IHomeResponse} from "@/types/inertia";
import GateListItem from "@/Components/Devices/GateListItem";

export default function Home({sites}: IHomeResponse) {

    return (
        <AppProvider>
            <Container>
                <List>
                    {sites.map((site) =>
                        <React.Fragment key={site.Id}>
                            <ListItem>
                                <div>{site.Name}</div>
                            </ListItem>
                            <List>
                                {site.DevicesTree.Children.map((gate) => (
                                    <GateListItem key={gate.Id} gate={gate}></GateListItem>
                                ))}
                            </List>
                        </React.Fragment>
                    )}
                </List>
            </Container>
        </AppProvider>
    );
}
