import {ISite} from "@/types/inertia";
import {List, ListItem, ListItemText} from "@mui/material";
import GatewayListItem from "@/Components/Connect/GatewayListItem";

interface SiteListItemProps {
    site: ISite;
}

export default function SiteListItem({site}: SiteListItemProps) {
    return (
        <>
            <ListItem>
                <ListItemText>Site: {site.name}</ListItemText>
            </ListItem>
            {site.devices.length > 0 && (
                <List>
                    {site.devices.map((gateway) => (
                        <GatewayListItem key={gateway.id} gateway={gateway}/>
                    ))}
                </List>
            )}
        </>
    );
}
