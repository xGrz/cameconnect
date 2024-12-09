import {List, ListItem} from "@mui/material";
import {IGateDevice} from "@/types/inertia";
import DeviceListItem from "@/Components/Devices/DeviceListItem";

interface GateListItemProps {
    gate: IGateDevice;
}

export default function GateListItem({gate}: GateListItemProps) {
    return (
        <>
            <ListItem>
                {gate.Name}
            </ListItem>
            <List>
                {gate.Children && gate.Children.map(device => (
                    <DeviceListItem device={device} key={device.Id}/>
                ))}
            </List>
        </>
    )
}
