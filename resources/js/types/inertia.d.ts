export interface IBaseResponse extends Record<string, any> {

}

export interface IHomeResponse extends IBaseResponse {
    sites: ISite[];
}

interface IConnectUser {
    Id: number | null;
    Username: string | null;
    Email: string | null;
    FirstName: string | null;
    LastName: string | null;
    TechnicianCode: number;
}

export interface ISite {
    Id: number;
    Name: string;
    Description: string;
    Address: string;
    Timezone: string;
    TechnicianId: number;
    UserId: number;
    User: IConnectUser;
    Devices: IDevice[];
    DevicesTree: IDeviceTree;
}

interface IBaseDevice {
    Id: number;
    Name: string;
    Description: string;
    IconName: string;
    ModelId: number;
    ModelName: string;
    SiteId: number;
    OwnerId: number;
    Keycode: number;
    Children?: IDevice[];
}

export interface IGateDevice extends IBaseDevice {
}

export interface IDevice extends IBaseDevice {
    AllowedInputs: [];

}

export interface IDeviceTree {
    Children: IGateDevice[];
}
